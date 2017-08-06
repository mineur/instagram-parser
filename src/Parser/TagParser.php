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
    
    /**
     * Init execution method
     *
     * @param string        $tag
     * @param callable|null $callback
     * @return mixed|void
     */
    public function parse(
        string $tag,
        callable $callback = null
    )
    {
        $this->ensureParserIsNotEmpty($tag);
        
        $hasNextPage     = true;
        $itemsPerRequest = 10;
        $cursor = '';
        
        while (true === $hasNextPage) {
            $response    = $this->makeRequest(self::ENDPOINT, [
                'query' => [
                    'query_id' => $this->queryId->__toString(),
                    'variables' => json_encode([
                        'tag_name' => $tag,
                        'first' => $itemsPerRequest,
                        'after' => $cursor
                    ])
                ]
            ]);
            $cursor      = $response['page_info']['end_cursor'];
            $hasNextPage = $response['page_info']['has_next_page'];
            
            $posts = $response['edges'];
            foreach ($posts as $post) {
                $post['node']['hash_reference'] = $cursor;
                
                $this->returnPostObject($post['node'], $callback);
            }
            
            sleep(rand(0, 3)); // avoid DoS
        }
    }
    
    /**
     * Make the parsing request
     *
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
        
        return $parsedResponse['data']['hashtag']['edge_hashtag_to_media'];
    }
}