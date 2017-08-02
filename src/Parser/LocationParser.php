<?php

namespace Parser;


use Mineur\InstagramParser\Parser\AbstractParser;

class LocationParser extends AbstractParser
{
    /** Resource endpoint */
    const ENDPOINT = '/graphql/query/?query_id=%s&tag_name=%s&first=%d&after=%s';
    
    /** @var HttpClient */
    private $httpClient;
    
    /** @var string */
    private $queryId;
    
    public function parse(
        string $parsedItem,
        callable $callback
    )
    {
        // TODO: Implement parse() method.
    }
}