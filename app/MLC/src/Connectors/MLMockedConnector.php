<?php
namespace AlfredNutileInc\MachineLearningClient\Connectors;

use AlfredNutileInc\MachineLearningClient\Client;
use AlfredNutileInc\MachineLearningClient\Drivers\MockMachineLearningService;


class MLMockedConnector 
{

    public function connect(array $config)
    {
        $client = new Client();
        return new MockMachineLearningService($client);
    } 
}