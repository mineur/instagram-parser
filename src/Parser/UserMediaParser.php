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

use Mineur\InstagramParser\Exception\InstagramException;
use Mineur\InstagramParser\Http\HttpClient;
use Mineur\InstagramParser\Model\QueryId;

/**
 * Class UserMediaParser
 *
 * @package Mineur\InstagramParser\Parser
 */
class UserMediaParser extends AbstractParser
{
    /** Resource endpoint */
    const ENDPOINT = '/graphql/query/?query_id=%s&id=%s&first=%d&after=%s';
    
    /** @var HttpClient */
    private $httpClient;
    
    /** @var string */
    private $queryId;
    
    /**
     * InstagramParser constructor.
     *
     * @param HttpClient     $httpClient
     * @param QueryId $queryId
     */
    public function __construct(
        HttpClient $httpClient,
        QueryId $queryId
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
        $this->ensureParserIsNotEmpty($userId);
        
        $hasNextPage = true;
        $itemsPerRequest = 10;
        
        while (true === $hasNextPage) {
            $endpoint = sprintf(
                self::ENDPOINT,
                $this->queryId,
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
            ->get($endpoint, [])
        ;
        
        $parsedResponse = json_decode((string) $response, true);
        if ($parsedResponse['status'] !== 'ok') {
            throw new InstagramException(
                'Unknown Instagram error.'
            );
        }
        
        return $parsedResponse['data']['user']['edge_owner_to_timeline_media'];
    }
}