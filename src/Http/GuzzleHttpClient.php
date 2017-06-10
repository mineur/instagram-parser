<?php

namespace Mineur\InstagramParser\Http;

use GuzzleHttp\Client;

class GuzzleHttpClient implements HttpClient
{
    const BASE_ENDPOINT = 'https://www.instagram.com/graphql/query/?';
    
    private $client;
    
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
     * @return \GuzzleHttp\Message\FutureResponse|\GuzzleHttp\Message\ResponseInterface|\GuzzleHttp\Ring\Future\FutureInterface|null
     */
    public function get(string $endpoint)
    {
        return $this->client->get(
            self::BASE_ENDPOINT . $this->queryId . $endpoint
        );
    }
}