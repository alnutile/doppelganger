<?php

namespace AlfredNutileInc\MachineLearningClient;
use AlfredNutileInc\MachineLearningClient\Client;
use AlfredNutileInc\MachineLearningClient\MLManager;
use Illuminate\Support\Facades\Facade;

/**
 * @see MLManager
 * @see Client
 */
class MLClient extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ml_client';
    }
}
