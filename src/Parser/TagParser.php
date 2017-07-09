<?php

/*
 * Mineur/instagram-parser package
 *
 * Feel free to contribute!
 *
 * @license MIT
 * @author alexhoma <alexcm.14@gmail.com>
 */

namespace Mineur\InstagramParser\Parser;

use Mineur\InstagramParser\EmptyRequiredParamException;
use Mineur\InstagramParser\Http\HttpClient;
use Mineur\InstagramParser\InstagramException;

/**
 * Class TagParser
 *
 * @package Mineur\InstagramParser\Parser
 */
class TagParser extends AbstractParser
{
    /** @var HttpClient */
    private $httpClient;
    
    /** @var string */
    private $queryId;
    
    /**
     * Tags Parser constructor.
     *
     * @param HttpClient $httpClient
     * @param string     $queryId
     */
    public function __construct(
        HttpClient $httpClient,
        string $queryId
    )
    {
        $this->httpClient = $httpClient;
        $this->queryId    = $queryId;
    }
    
    /**
     * Init execution method
     *
     * @param string        $tag
     * @param callable|null $callback
     */
    public function parse(
        string $tag,
        callable $callback = null
    )
    {
        $hasNextPage     = true;
        $itemsPerRequest = 10;
        $queryId         = $this->ensureQueryIdIsNotEmpty($this->queryId);
        $this->ensureHasATagToParse($tag);
        
        while (true === $hasNextPage) {
            $endpoint = sprintf(
                '/graphql/query/?query_id=%s&tag_name=%s&first=%d&after=%s',
                $queryId,
                $tag,
                $itemsPerRequest,
                $cursor ?? ''
            );
            
            $response    = $this->makeRequest($endpoint);
            $cursor      = $response['page_info']['end_cursor'];
            $hasNextPage = $response['page_info']['has_next_page'];
            
            $posts = $response['edges'];
            foreach ($posts as $post) {
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
     * Ensure Instagram GraphQL query
     * has a non empty queryId
     *
     * @param string $queryId
     * @return string
     * @throws EmptyRequiredParamException
     */
    private function ensureQueryIdIsNotEmpty(string $queryId)
    {
        if (empty($queryId)) {
            throw new EmptyRequiredParamException(
                'You must include a valid queryId.'
            );
        }
        
        return $queryId;
    }
    
    /**
     * Ensure there is a tag to parse
     *
     * @param string $tag
     * @throws EmptyRequiredParamException
     */
    private function ensureHasATagToParse(string $tag)
    {
        if (empty($tag)) {
            throw new EmptyRequiredParamException(
                'You must parse for one tag.'
            );
        }
    }
}