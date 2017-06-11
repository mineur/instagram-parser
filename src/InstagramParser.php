<?php

namespace Mineur\InstagramParser;

use Mineur\InstagramParser\Http\HttpClient;

class InstagramParser
{
    /** @var HttpClient */
    private $httpClient;
    
    /**
     * InstagramParser constructor.
     *
     * @param HttpClient $httpClient
     */
    private function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }
    
    /**
     * Open the Http client
     *
     * @param HttpClient $httpClient
     * @return InstagramParser
     */
    public static function open(HttpClient $httpClient): self
    {
        return new self($httpClient);
    }
    
    /**
     * Init execution method
     *
     * @param string        $tag
     * @param callable|null $callback
     */
    public function parse(string $tag, callable $callback = null)
    {
        $hasNextPage = true;
        $itemsPerRequest = 10;
        $this->ensureHasATagToParse($tag);
    
        while(true === $hasNextPage) {
            $endpoint = sprintf('&tag_name=%s&first=%d&after=%s',
                $tag,
                $itemsPerRequest,
                $cursor ?? ''
            );
            
            $response    = $this->makeRequest($endpoint);
            $cursor      = $response['page_info']['end_cursor'];
            $hasNextPage = $response['page_info']['has_next_page'];
    
            $posts = $response['edges'];
            foreach($posts as $post) {
                $this->returnPostObject($post['node'], $callback);
            }
            
            sleep(rand(0, 3)); // avoid DoS
        }
    }
    
    /**
     * Make the parsing request
     *
     * @param string $endpoint
     * @return array
     * @throws InstagramException
     */
    private function makeRequest(string $endpoint): array
    {
        $response = $this
            ->httpClient
            ->get($endpoint);
        
        $parsedResponse = json_decode((string) $response, true);
        if ($parsedResponse['status'] !== 'ok') {
            throw new InstagramException(
                'Unknown Instagram error.'
            );
        }
        
        return $parsedResponse['data']['hashtag']['edge_hashtag_to_media'];
    }
    
    /**
     * Return an hydrated InstagramPost object
     *
     * @param array         $post
     * @param callable|null $callback
     * @return array|mixed
     */
    private function returnPostObject(
        array $post,
        callable $callback = null
    )
    {
        if ($callback !== null) {
            return call_user_func($callback, $post);
        }
    
        return $post;
    }
    
    /**
     * @param string $tag
     * @throws EmptyTagsException
     */
    private function ensureHasATagToParse(string $tag)
    {
        if (empty($tag)) {
            throw new EmptyTagsException(
                'You must parse for one tag.'
            );
        }
    }
}