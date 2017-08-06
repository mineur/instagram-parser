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

class LocationParser extends AbstractParser
{
    /** Resource endpoint */
    const ENDPOINT = '/graphql/query/';
    
    /** @var HttpClient */
    private $httpClient;
    
    /** @var string */
    private $queryId;
    
    /**
     * Location Parser constructor.
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
        string $locationId,
        callable $callback
    )
    {
        $this->ensureParserIsNotEmpty($locationId);
        
        $hasNextPage     = true;
        $itemsPerRequest = 12;
        $cursor          = '1574109516080267643';
        
        while (true === $hasNextPage) {
            $endpoint = self::ENDPOINT .
                 '?query_id=' . $this->queryId->__toString() .
                 '&variables=' .
                     '%7B%22id%22%3A%22' . $locationId .
                     '%22%2C%22first%22%3A' . $itemsPerRequest .
                     '%2C%22after%22%3A%22' . $cursor .
                 '%22%7D'
            ;
            
            $response = $this->makeRequest($endpoint, []);
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