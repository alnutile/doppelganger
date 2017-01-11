<?php

namespace AlfredNutileInc\MachineLearningClient\Drivers;

use AlfredNutileInc\MachineLearningClient\Client;
use AlfredNutileInc\MachineLearningClient\DTOs\SentimentDTO;
use AlfredNutileInc\MachineLearningClient\Interfaces\TextSentimentInterface;
use AlfredNutileInc\MachineLearningClient\Transformers\SentimentResultsTransformer;

class MockMachineLearningService extends BaseDriver implements TextSentimentInterface
{

    protected $payload = [];

    /**
     * @var SentimentResultsTransformer
     */
    protected $transformer;

    /**
     * @var SentimentResultsTransformer
     */
    protected $results;
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->client->addToHeaders(
            ['Foo-Bar-Key' => 'foobar']);
    }
    
    public function sentimentRequest(SentimentDTO $payload) {

        $payload->validate();
        
        $this->makeRequest();
        
        $this->transformSentimentResults();
        
        return $this->results;
    }
    
    protected function makeRequest() {
        //Mock results till ready
        
        $this->results = json_decode(__DIR__ . '/../../tests/fixtures/sentiment_results.json', true);
        
        return $this->results;
    }
    
    protected function transformSentimentResults() {
        $results = $this->getTransformer()->transform($this->results);
        
        $this->setResults($results);
    }

    public function getResults()
    {
        return $this->results;
    }

    public function setResults($results)
    {
        $this->results = $results;
    }

    /**
     * @return SentimentResultsTransformer
     */
    public function getTransformer()
    {
        if(!$this->transformer) {
            $this->setTransformer();
        }
        return $this->transformer;
    }

    /**
     * @param SentimentResultsTransformer $transformer
     */
    public function setTransformer($transformer = null)
    {
        if(!$transformer) {
            $transformer = new SentimentResultsTransformer();
        }
        $this->transformer = $transformer;
    }

    protected function setUpClient()
    {
        // TODO: Implement setUpClient() method.
    }

    protected function driverConfig()
    {
        return [];
    }
}