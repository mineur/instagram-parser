<?php

namespace Mineur\InstagramApi\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Instagram\ImplicitAuth;

class GuzzleHttpClient implements HttpClient
{
    const REDIRECT_URL = 'http://localhost:3000';
    
    private $accessToken;
    
    public function __construct(
        string $username,
        string $password,
        string $clientId,
        string $scope
    )
    {
        $config = [
            'username'     => $username,
            'password'     => $password,
            'client_id'    => $clientId,
            'redirect_uri' => self::REDIRECT_URL,
            'scope'        => $scope
        ];
        
        $this->setAccesstoken($config);
    }
    
    private function setAccesstoken($config)
    {
        $client = new Client();
        $implicitAuth = new ImplicitAuth($config);
        
        $client->getEmitter()->attach($implicitAuth);
        $client->post('https://instagram.com/oauth/authorize');
        
        $this->accessToken = $implicitAuth->getAccessToken();
    }
    
    public function get(
        string $endpoint,
        array $options = []
    )
    {
        $options[] = $this->accessToken;
        
        $response = $this->client->get($endpoint, $options);
        
        dump($response->getBody());
    }
}