<?php

namespace Mineur\InstagramApi;

use InstagramApi;
use Mineur\InstagramApi\Http\HttpClient;

class TagsApi extends InstagramApi
{
    private $httpClient;
    
    private function __construct(HttpCLient $httpClient)
    {
        $this->httpClient = $httpClient;
    }
    
    public static function open(HttpClient $httpClient): self
    {
        return new self($httpClient);
    }
    
    public function getTagObject(string $tag)
    {
        return $this->httpClient->get(
            self::BASE_ENDPOINT . 'tags/' . $tag
        );
    }
    
    public function getRecentlyTaggedMedia(string $tag)
    {
        return $this->httpClient->get(
            self::BASE_ENDPOINT . 'tags/' . $tag . '/media/recent'
        );
    }
    
    public function searchTagByName(string $tag)
    {
        return $this->httpClient->get(
            self::BASE_ENDPOINT . 'tags/search',
            [
                'q' => $tag
            ]
        );
    }
}