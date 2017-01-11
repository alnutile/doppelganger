<?php

namespace AlfredNutileInc\MachineLearningClient\Transformers;

class SentimentResultsTransformer
{

    protected $results = [];
    
    public function transform($results) {
        //do something
        
        $this->results = $results;
        
        return $this;
        
    }
    
    public function validate() {

        if(empty($this->results)) {
            throw new \Exception("Results is empty");
        }


        if(!isset($this->results['documents'])) {
            throw new \Exception("Results is missing documents key");
        }


        return true;
        
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param array $results
     */
    public function setResults($results)
    {
        $this->results = $results;
    }

}