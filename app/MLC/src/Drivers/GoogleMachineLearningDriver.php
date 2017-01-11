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
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class GoogleMachineLearningDriver  extends BaseDriver implements TextSentimentInterface
{

    /**
     * @var Client
     */
    protected $client;

    public function __construct($client = null)
    {
        if(!$client) {
            $this->setUpClient();
        } else {
            $this->client = $client;
        }

    }


    public function sentimentRequest(SentimentDTO $payload)
    {
        $payload->validate();
        
        $payload = $this->transformRequest($payload);

        /** @var Response $results */
        $results = $this->client->post('/text/analytics/v2.0/sentiment', $payload);

        //Transform results?

        return $results;

    }
    
    protected function transformRequest($payload) {
        dd($payload);
    }

    protected function makeRequest()
    {
        // TODO: Implement makeRequest() method.
    }

    protected function transformSentimentResults()
    {
        // TODO: Implement transformSentimentResults() method.
    }

    protected function setUpClient($config = [])
    {
        $config = array_merge($this->driverConfig(), $config);

        $client = new \AlfredNutileInc\MachineLearningClient\Client($config);

        $client->setBaseUrl(env('GOOGLE_BASE_URL'));

        $this->client = $client;
    }
    protected function driverConfig()
    {
        return ['Authorization' => "Bearer:" . env("GOOGLE_APPLICATION_CREDENTIALS")];
    }
}