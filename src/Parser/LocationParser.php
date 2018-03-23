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

class LocationParser extends AbstractParser
{
    /** Resource endpoint */
    const ENDPOINT = '/graphql/query/';
    
    /** @var HttpClient */
    private $httpClient;
    
    /** @var string */
    private $queryHash;
    
    /**
     * Location Parser constructor.
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
        string $locationId,
        callable $callback
    )
    {
        $this->ensureParserIsNotEmpty($locationId);
        
        $hasNextPage     = true;
        $itemsPerRequest = 12;
        $cursor          = '';
        
        while (true === $hasNextPage) {
            $response = $this->makeRequest(self::ENDPOINT, [
                'query' => [
                    'query_hash' => $this->queryHash->__toString(),
                    'variables' => json_encode([
                        'id' => $locationId,
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
            );
        
        $parsedResponse = json_decode((string) $response, true);
        if ($parsedResponse['status'] !== 'ok') {
            throw new InstagramException(
                'Unknown Instagram error.'
            );
        }
        
        return $parsedResponse['data']['location']['edge_location_to_media'];
    }
}