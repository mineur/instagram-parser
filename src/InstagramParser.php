<?php

namespace Mineur\InstagramApi;

use Mineur\InstagramApi\Http\HttpClient;

class InstagramParser
{
    const BASE_ENDPOINT = 'https://www.instagram.com/graphql/query/?';
    
    private $httpClient;
    
    private $queryId;
    
    private $tags;
    
    private $numberOfItems;
    
    /**
     * InstagramParser constructor.
     *
     * @param HttpClient $httpClient
     * @param string     $queryId
     */
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
    
    public function parse()
    {
        $this->ensureHasTagsToParse();
        
        $itemsForTag = $this->numberOfItems ?? 10;
        
        foreach ($this->tags as $tag) {
            $endpoint = sprintf(
                self::BASE_ENDPOINT . 'query_id=' . $this->queryId . '&tag_name=%s&first=%d',
                $tag, $itemsForTag
            );
            $response = $this->httpClient->get($endpoint);
            
            dump($response->getBody());die;
            
            $this->returnInstagramPostObject(
                (string) $response->getBody()
            );
        }
    }
    
    public function searchFor(array $tags)
    {
        $this->tags = $tags;
        
        return $this;
    }
    
    public function numberOfItems(int $items)
    {
        $this->numberOfItems = $items;
        
        return $this;
    }
    
    private function returnInstagramPostObject(string $post)
    {
        return json_decode(
            $post,
            true
        );
    }
    
    /**
     * @throws EmptyTagsException
     */
    private function ensureHasTagsToParse()
    {
        if (null === $this->tags || count($this->tags) === 0) {
            throw new EmptyTagsException(
                'You must parse for at least one tag.'
            );
        }
    }
}