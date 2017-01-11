<?php

namespace AlfredNutileInc\MachineLearningClient\Connectors;

use AlfredNutileInc\MachineLearningClient\Client;
use AlfredNutileInc\MachineLearningClient\Drivers\AWSMachineLearningDriver;
use AlfredNutileInc\MachineLearningClient\Drivers\MicrosoftCognitiveServices;
use AlfredNutileInc\MachineLearningClient\Drivers\MockMachineLearningService;

class MSConnector
{

    public function connect(array $config)
    {
        return new MicrosoftCognitiveServices();
    } 
}