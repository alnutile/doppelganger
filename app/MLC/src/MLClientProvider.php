<?php

namespace AlfredNutileInc\MachineLearningClient;

use AlfredNutileInc\MachineLearningClient\Connectors\MLMockedConnector;
use AlfredNutileInc\MachineLearningClient\Connectors\MSConnector;
use AlfredNutileInc\MachineLearningClient\Drivers\AWSMachineLearningDriver;
use AlfredNutileInc\MachineLearningClient\Connectors\AWSConnector;
use Illuminate\Support\ServiceProvider;

class MLClientProvider extends ServiceProvider
{
    public $services;
    
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->services = ['AWS', 'MS', 'Mocked'];

        $this->app->singleton('ml_client', function ($app) {
            // Once we have an instance of the queue manager, we will register the various
            // resolvers for the queue connectors. These connectors are responsible for
            // creating the classes that accept queue configs and instantiate queues.
            $manager = new MLManager($app);

            $this->registerConnectors($manager);

            return $manager;
        });
        
        
        $this->app->singleton(\AlfredNutileInc\MachineLearningClient\Interfaces\GeneralDriverInterface::class, function($app) {

            $client = new AWSMachineLearningDriver();

            return $client;
        });
    }

    public function registerConnectors($manager)
    {
        foreach ($this->services as $connector) {
            $this->{"register{$connector}Connector"}($manager);
        }
    }


    protected function registerMSConnector($manager)
    {
        $manager->addConnector('ms', function () {
            return new MSConnector();
        });
    }

    protected function registerAWSConnector($manager)
    {
        $manager->addConnector('aws', function () {
            return new AWSConnector();
        });
    }
    
    protected function registerMockedConnector($manager)
    {
        $manager->addConnector('mocked', function () {
            return new MLMockedConnector();
        });
    }

    public function provides()
    {
        return [
            'ml_client'
        ];
    }
}
