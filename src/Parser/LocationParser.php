<?php

namespace Mineur\InstagramParser\Parser;

use Mineur\InstagramParser\Exception\EmptyRequiredParamException;
use Mineur\InstagramParser\Http\HttpClient;
use Mineur\InstagramParser\Exception\InstagramException;
use Mineur\InstagramParser\Model\QueryId;


class LocationParser extends AbstractParser
{
    /** Resource endpoint */
    const ENDPOINT = '/graphql/query/?query_id=%s&id=%s&first=%d&after=%s';
    
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
        
        while (true === $hasNextPage) {
            $endpoint = sprintf(
                self::ENDPOINT,
                $this->queryId,
                $locationId,
                $itemsPerRequest,
                $cursor ?? ''
            );
            
            $response    = $this->makeRequest($endpoint, []);
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
    ): array
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
        
        return $parsedResponse['data']['hashtag']['edge_hashtag_to_media'];
    }
}