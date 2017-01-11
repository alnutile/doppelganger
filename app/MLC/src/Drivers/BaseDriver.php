<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 7/11/16
 * Time: 8:07 PM
 */

namespace AlfredNutileInc\MachineLearningClient\Drivers;


use AlfredNutileInc\MachineLearningClient\DTOs\SentimentDTO;
use Illuminate\Contracts\Container\Container;

abstract class BaseDriver
{

    /**
     * @var Container 
     */
    public $container;
    
    protected $client;
    
    protected $payload = [];

    protected $results = [];

    abstract public function sentimentRequest(SentimentDTO $payload);

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    abstract protected function makeRequest();

    abstract protected function transformSentimentResults();
    
    abstract protected function setUpClient();
    
    abstract protected function driverConfig();

    public function setContainer(Container $container)
    {
        $this->container = $container;
    }
}