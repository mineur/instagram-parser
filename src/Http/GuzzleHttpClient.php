<?php

namespace Mineur\InstagramParser\Http;

use GuzzleHttp\Client;

class GuzzleHttpClient implements HttpClient
{
    const BASE_INSTAGRAM_ENDPOINT = 'https://www.instagram.com';
    
    /** @var Client */
    private $client;
    
    /**
     * GuzzleHttpClient constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }
    
    /**
     * @param string $endpoint
     * @return string
     */
    public function get(string $endpoint): string
    {
        $clientResponse = $this->client->get(
            self::BASE_INSTAGRAM_ENDPOINT . $endpoint
        );
        dump($clientResponse->getBody()->getContents());
        return $clientResponse->getBody();
    }
}