<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 7/12/16
 * Time: 7:26 PM
 */

namespace AlfredNutileInc\MachineLearningClient\Drivers;


use AlfredNutileInc\MachineLearningClient\DTOs\SentimentDTO;
use AlfredNutileInc\MachineLearningClient\Interfaces\TextSentimentInterface;
use AlfredNutileInc\MachineLearningClient\Interfaces\GeneralDriverInterface;
use Illuminate\Support\Facades\Config;

class AWSMachineLearningDriver  extends BaseDriver implements TextSentimentInterface, GeneralDriverInterface
{
    /**
     * @var \Aws\MachineLearning\MachineLearningClient
     */
    protected $client;

    protected $request_for_aws;
    
    public $original_request;
    
    public $base_url;

    public function __construct($client = null)
    {
        if(!$client) {
            $this->setUpClient();
        } else {
            $this->client = $client;
        }
        
    }

    public function getDataSource($id, array $options) {

        //Transform as needed incoming and
        // results
        //Right now just working on ideas
        return $this->getClient()->getDataSource([
            'DataSourceId' => $id,
            'Verbose' => (isset($options['verbose'])) ? : false
        ]);

    }

    public function getModel($id, array $options) {
        //Transform as needed incoming and
        // results
        //Right now just working on ideas
        return $this->getClient()->getMLModel([
            'MLModelId' => $id,
            'Verbose' => (isset($options['verbose'])) ? : false
        ]);

    }

    public function getEvaluation($id) {

        //Transform as needed incoming and
        // results
        //Right now just working on ideas
        return $this->getClient()->getEvaluation([
            'EvaluationId' => $id
        ]);

    }

    public function sentimentRequest(SentimentDTO $payload)
    {
        $payload->validate();

        $this->transformRequestPayload($payload);

        $results = [];

        foreach($this->request_for_aws as $request) {
            $request['MLModelId']       = Config::get('mlservice.connections.aws.ml_id');
            $request['PredictEndpoint'] = Config::get('mlservice.connections.aws.base_url');
            $request['Record'] = $request;
            $results[] = $this->getClient()->predict($request);
        }
        
        $this->results = $results;

        $this->transformSentimentResults();
        
        return $this->results;
    }

    /**
     * @param $payload SentimentDTO
     */
    protected function transformRequestPayload($payload) {
        $documents = $payload->payload['documents'];
        
        $this->original_request = $documents;

        $this->request_for_aws = [];

        foreach($documents as $key => $document) {
            $this->request_for_aws[]['text'] = $document['text'];
        }

    }

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->base_url;
    }

    /**
     * @param mixed $base_url
     */
    public function setBaseUrl($base_url)
    {
        $this->base_url = $base_url;
    }

    protected function makeRequest()
    {
        // TODO: Implement makeRequest() method.
    }

    protected function transformSentimentResults()
    {
        $results_transformed = [];
        $results_transformed['documents'] = [];

        foreach($this->results as $key => $result) {
            $result = $result->toArray();

            $results_transformed['documents'][$key]['score'] = $result['Prediction']['predictedValue'];
        }

        $this->results = $results_transformed;
    }

    protected function setUpClient($config = [])
    {
        $config = array_merge($this->driverConfig(), $config);
        
        $client = new \Aws\MachineLearning\MachineLearningClient($config);
        
        $this->client = $client;
    }

    protected function driverConfig()
    {
        return [
            'credentials' => [
                'key' => Config::get('mlservice.connections.aws.key'),
                'secret' => Config::get('mlservice.connections.aws.secret')
            ],
            'version' => '2014-12-12',
            'region' => Config::get('mlservice.connections.aws.region'),
        ];
    }
}