<?php

namespace AlfredNutileInc\MachineLearningClient\Drivers;

use AlfredNutileInc\MachineLearningClient\DTOs\SentimentDTO;
use AlfredNutileInc\MachineLearningClient\Interfaces\TextSentimentInterface;
use GuzzleHttp\Client;
use Illuminate\Http\Response;

class MicrosoftCognitiveServices extends BaseDriver implements TextSentimentInterface
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


    public function faceDetect($payload)
    {
        /** @var Response $results */
        $results = $this->client->post('/face/v1.0/detect', $payload);

        //Transform results?

        return $results;
    }

    public function faceSimilar($payload)
    {
        $payload = $payload->payload;

        /** @var Response $results */
        $results = $this->client->post('/face/v1.0/findsimilars', $payload);

        //Transform results?

        return $results;
    }

    public function sentimentRequest(SentimentDTO $payload)
    {
        //Transform incoming Payload?
        // MS was the API I used as a base convention
        $payload->validate();
        $payload = $payload->payload;

        /** @var Response $results */
        $results = $this->client->post('/text/analytics/v2.0/sentiment', $payload);
        
        //Transform results?

        return $results;
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

        $client->setBaseUrl(env('MS_BASE_URL'));
        
        $this->client = $client;
    }

    protected function driverConfig()
    {
        return ['Ocp-Apim-Subscription-Key' => env("MS_KEY")];
    }
}