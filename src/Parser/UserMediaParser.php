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
 * Class UserMediaParser
 *
 * @package Mineur\InstagramParser\Parser
 */
class UserMediaParser extends AbstractParser
{
    /** @var HttpClient */
    private $httpClient;
    
    /** @var string */
    private $queryId;
    
    /**
     * InstagramParser constructor.
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
    
    public function parse(
        string $userId,
        callable $callback = null
    )
    {
        $hasNextPage = true;
        $queryId     = $this->ensureQueryIdIsNotEmpty($this->queryId);
        $this->ensureHasAUserIdToParse($userId);
        $itemsPerRequest = 10;
        
        while (true === $hasNextPage) {
            $endpoint = sprintf(
                '/graphql/query/?query_id=%s&id=%s&first=%d&after=%s',
                $queryId,
                $userId,
                $itemsPerRequest,
                $cursor ?? ''
            );
            
            $response    = $this->makeRequest($endpoint);
            $cursor      = $response['page_info']['end_cursor'];
            $hasNextPage = $response['page_info']['has_next_page'];
            
            $media = $response['edges'];
            foreach ($media as $post) {
                $this->returnPostObject($post['node'], $callback);
            }
    
            sleep(rand(0, 3)); // avoid DoS
        }
    }
    
    /**
     * @param string $endpoint
     * @return array
     * @throws InstagramException
     */
    private function makeRequest(string $endpoint): array
    {
        $response = $this
            ->httpClient
            ->get($endpoint);
        dump($response);
        
        $parsedResponse = json_decode((string) $response, true);
        if ($parsedResponse['status'] !== 'ok') {
            throw new InstagramException(
                'Unknown Instagram error.'
            );
        }
        
        return $parsedResponse['data']['user']['edge_owner_to_timeline_media'];
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
     * @param string $userId
     * @throws EmptyRequiredParamException
     */
    private function ensureHasAUserIdToParse(string $userId)
    {
        if (empty($userId)) {
            throw new EmptyRequiredParamException(
                'You must parse for one user, by its id.'
            );
        }
    }
}