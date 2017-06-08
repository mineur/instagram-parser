<?php

namespace Mineur\InstagramApi\Http;

use GuzzleHttp\Client;

class GuzzleHttpClient implements HttpClient
{
    private $client;
    
    public function __construct()
    {
        $this->client = new Client();
    }
    
    public function get(string $url)
    {
        return $this->client->get($url);
    }
}