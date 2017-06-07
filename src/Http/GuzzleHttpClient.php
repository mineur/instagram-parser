<?php

namespace Mineur\InstagramApi\Http;

use GuzzleHttp\Client;

class GuzzleHttpClient implements HttpClient
{
    const OAUTH_ACCESS_URI = 'https://api.instagram.com/oauth/access_token';
    
    private $client;
    
    public function __construct(
        string $clientId,
        string $clientSecret,
        string $grantType
//        string $code
    )
    {
        $this->client = (new Client())->post(self::OAUTH_ACCESS_URI, [
            'body' => [
                'client_id'     => $clientId,
                'client_secret' => $clientSecret,
                'grant_type'    => $grantType,
                'redirect_uri'  => 'http://localhost:3000',
//                'code'          => $code
            ]
        ]);
    }
    
    public function get(
        string $endpoint,
        array $query = null
    )
    {
        $response = $this->client->get($endpoint, [
            'query' => [
                'access_token' => ''
            ]
        ]);
        
        return $response->getBody();
    }
}