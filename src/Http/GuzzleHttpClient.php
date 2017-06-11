<?php

namespace Mineur\InstagramParser\Http;

use GuzzleHttp\Client;

class GuzzleHttpClient implements HttpClient
{
    const BASE_ENDPOINT = 'https://www.instagram.com/graphql/query/?';
    
    /** @var Client */
    private $client;
    
    /** @var string */
    private $queryId;
    
    /**
     * GuzzleHttpClient constructor.
     *
     * @param string $queryId
     */
    public function __construct(string $queryId)
    {
        $this->client = new Client();
        $this->queryId = "query_id=$queryId";
    }
    
    /**
     * @param string $endpoint
     * @return string
     */
    public function get(string $endpoint): string
    {
        $clientResponse = $this->client->get(
            self::BASE_ENDPOINT . $this->queryId . $endpoint
        );
        
        return $clientResponse->getBody();
    }
}