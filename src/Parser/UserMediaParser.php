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
use Mineur\InstagramParser\Model\QueryHash;

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
    private $queryHash;
    
    /**
     * InstagramParser constructor.
     *
     * @param HttpClient     $httpClient
     * @param QueryHash $queryHash
     */
    public function __construct(
        HttpClient $httpClient,
        QueryHash $queryHash
    )
    {
        $this->httpClient = $httpClient;
        $this->queryHash    = $queryHash;
    }
    
    public function parse(
        string $userId,
        callable $callback = null
    )
    {
        $this->ensureParserIsNotEmpty($userId);
        
        $hasNextPage = true;
        $itemsPerRequest = 10;
        $cursor = '';
        
        while (true === $hasNextPage) {
            $response = $this->makeRequest(self::ENDPOINT, [
                'query' => [
                    'query_hash' => $this->queryHash->__toString(),
                    'variables' => json_encode([
                        'id' => $userId,
                        'first' => $itemsPerRequest,
                        'after' => $cursor
                    ])
                ]
            ]);
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
     * @param array  $options
     * @return array
     * @throws InstagramException
     */
    private function makeRequest(
        string $endpoint,
        array $options
    ) : array
    {
        $response = $this
            ->httpClient
            ->get(
                $endpoint,
                $options
            )
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