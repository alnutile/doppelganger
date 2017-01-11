<?php

namespace AlfredNutileInc\MachineLearningClient\DTOs;

class SentimentDTO
{
    
    public $payload = [];

    public static $payload_default = [
        'documents' => [
            [
                'id' => 1,
                'text' => "Some Text"
            ]
        ]
    ];

    public static function getPayloadStub() {
        return self::$payload_default;
    }

    public function __construct($payload)
    {
        $this->payload = $payload;
    }
    
    
    
    public function validate() {
        
        
        if(empty($this->payload)) {
            throw new \Exception("Payload is empty");
        }
        
        
        if(!isset($this->payload['documents'])) {
            throw new \Exception("Payload is missing documents key");
        }
        
        if(empty($this->payload['documents'])) {
            throw new \Exception("Payload is missing documents to process");
        }
        
        return true;
        
    }
    
    
    

}