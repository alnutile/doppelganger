<?php

namespace AlfredNutileInc\MachineLearningClient\Interfaces;

use AlfredNutileInc\MachineLearningClient\DTOs\SentimentDTO;

interface TextSentimentInterface
{

    function sentimentRequest(SentimentDTO $payload);
    

}