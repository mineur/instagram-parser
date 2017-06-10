<?php

namespace Mineur\InstagramParser;

use Mineur\InstagramParser\Http\HttpClient;

class InstagramParser
{
    private $httpClient;
    
    private $tags;
    
    private $numberOfItems;
    
    /**
     * InstagramParser constructor.
     *
     * @param HttpClient $httpClient
     */
    private function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }
    
    public static function open(HttpClient $httpClient): self
    {
        return new self($httpClient);
    }
    
    public function parse()
    {
//        $this->ensureHasTagsToParse();
        
        $itemsForTag = $this->numberOfItems ?? 10;
        
        foreach($this->tags as $tag) {
            $endpoint = sprintf('&tag_name=%s&first=%d',
                $tag, $itemsForTag
            );
            $response = $this->httpClient->get($endpoint);
            sleep(5);
        }
        
    
        return json_decode(
            (string) $response->getBody(),
            true
        );
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