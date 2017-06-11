<?php

namespace Mineur\InstagramParser;

use Mineur\InstagramParser\Http\HttpClient;

class InstagramParser
{
    const MAX_ITEMS_TO_SEARCH = 600;
    
    const MIN_ITEMS_TO_SEARCH = 10;
    
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
        $hasNextPage = true;
        $itemsForTag = $this->numberOfItems ?? self::MIN_ITEMS_TO_SEARCH;
        
        while(true === $hasNextPage) {
            $endpoint = sprintf('&tag_name=%s&first=%d&after=%s',
                $this->tags[0],
                $itemsForTag,
                $cursor ?? ''
            );
            
            $response    = $this->makeRequest($endpoint);
            $cursor      = $response['page_info']['end_cursor'];
            $hasNextPage = $response['page_info']['has_next_page'];
            
            $this->parseEachPostsResponse($response);
            
            sleep(rand(0, 5)); // avoid DoS
        }
    }
    
    private function makeRequest(string $endpoint)
    {
        $response = $this
            ->httpClient
            ->get($endpoint)
            ->getBody();
        
        $parsedResponse = json_decode((string) $response, true);
        if ($parsedResponse['status'] !== 'ok') {
            echo 'an error ocurred'; die;
        }
        
        return $parsedResponse['data']['hashtag']['edge_hashtag_to_media'];
    }
    
    private function parseEachPostsResponse(array $response)
    {
        $posts = $response['edges'];
        
        foreach($posts as $post) {
            $this->returnPostObject($post['node']);
        }
    }
    
    private function returnPostObject(array $post)
    {
        return $post;
    }
    
    public function searchFor(array $tags)
    {
        $this->ensureHasTagsToParse($tags);
        $this->tags = $tags;
        
        return $this;
    }
    
    public function numberOfItems(int $items)
    {
        $this->ensureIsNotSearchingMoreThanMaxNumberOfItems($items);
        $this->numberOfItems = $items;
        
        return $this;
    }
    
    /**
     * @param array $tags
     * @throws EmptyTagsException
     */
    private function ensureHasTagsToParse(array $tags)
    {
        if (null === $tags || count($tags) === 0) {
            throw new EmptyTagsException(
                'You must parse for at least one tag.'
            );
        }
    }
    
    /**
     * @param int $items
     * @throws MaxSearchableResultsException
     */
    private function ensureIsNotSearchingMoreThanMaxNumberOfItems(int $items)
    {
        if ($items >= self::MAX_ITEMS_TO_SEARCH) {
            throw new MaxSearchableResultsException(
                sprintf(
                    'You cannot search more than %s items at once.',
                    self::MAX_ITEMS_TO_SEARCH
                )
            );
        }
    }
}