<?php

namespace Mineur\InstagramApi;

use Mineur\InstagramApi\Http\HttpClient;

class InstagramParser
{
    const BASE_ENDPOINT = 'https://www.instagram.com/graphql/query/?';
    
    private $httpClient;
    
    private $queryId;
    
    private function __construct(
        HttpClient $httpClient,
        string $queryId
    )
    {
        $this->httpClient = $httpClient;
        $this->queryId = $queryId;
    }
    
    public static function open(
        HttpClient $httpClient,
        string $queryId
    ): self
    {
        return new self($httpClient, $queryId);
    }
    
    public function getPostsByTagName(
        string $tagName,
        int $offset = 10
    )
    {
        $endpoint = sprintf(
            self::BASE_ENDPOINT . 'query_id=' . $this->queryId . '&tag_name=%s&first=%d',
            $tagName, $offset
        );
        
        $response = $this->httpClient->get($endpoint);
        
        return json_decode(
            (string) $response->getBody(),
            true
        );
    }
}