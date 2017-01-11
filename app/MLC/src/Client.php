<?php

namespace AlfredNutileInc\MachineLearningClient;


class Client
{

    /**
     * @var \GuzzleHttp\Client
     */
    protected $http_client;

    protected $base_url;

    protected $headers = [];

    public function __construct(array $headers = [])
    {
        $this->headers = $headers;
    }

    protected function request() {
        $this->getHttpClient();
    }

    public function get($path, $options) {
        $results = $this->getHttpClient()->get($path, $options);

        return json_decode($results->getBody(), true);
    }

    public function post($path, $payload) {
        $results = $this->getHttpClient()->post($path, ['json' => $payload]);

        return json_decode($results->getBody(), true);
    }

    public function put() {

    }

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->base_url;
    }

    /**
     * @param mixed $base_url
     */
    public function setBaseUrl($base_url)
    {
        $this->base_url = $base_url;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient()
    {
        if(!$this->http_client) {
            $this->setUpHttpClient();
        }

        return $this->http_client;
    }

    protected function defaultHeaders() {
        return [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json'
        ];
    }

    protected function setUpHttpClient() {

        $headers = $this->headers + $this->defaultHeaders();
        
        $config = [
            'base_uri'          => $this->getBaseUrl(),
            'timeout'           => 0,
            'allow_redirects'   => false,
            'verify'            => false,
            'headers'           => $headers
        ];

        $client = new \GuzzleHttp\Client($config);

        $this->setHttpClient($client);

    }

    /**
     * @param mixed $http_client
     */
    public function setHttpClient(\GuzzleHttp\Client $http_client)
    {
        $this->http_client = $http_client;
    }


}