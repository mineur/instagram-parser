<?php

namespace Mineur\InstagramParser\Parser;


use Mineur\InstagramParser\Http\HttpClient;
use Mineur\InstagramParser\Model\InstagramPost;

class UserMediaParser
{
    /** @var HttpClient */
    private $httpClient;
    
    /**
     * InstagramParser constructor.
     *
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }
    
    public function parse(string $username)
    {
        $hasNextPage     = true;
        $mediaCollection = [];
        
        while (true === $hasNextPage) {
            $endpoint = sprintf(
                '/%s/?__a=1&after=%s',
                $username,
                $cursor ?? ''
            );
            
            $response       = $this->makeRequest($endpoint);
            $truncatedMedia = $response['user']['media']['nodes'];
            $hasNextPage    = $response['page_info']['has_next_page'];
            $cursor         = $response['page_info']['end_cursor'];
            
            foreach ($truncatedMedia as $media) {
                $mediaCollection[] = $media;
            }
        }
        
        dump($mediaCollection);
    }
    
    /**
     * @param string $endpoint
     * @return array
     */
    private function makeRequest(string $endpoint): array
    {
        $response = $this
            ->httpClient
            ->get($endpoint);
        
        return json_decode((string) $response, true);
    }
}