<?php

namespace Mineur\InstagramParser\Parser;

use Mineur\InstagramParser\Http\HttpClient;

/**
 * Class UserAbstractParser
 *
 * @package Mineur\InstagramParser\Parser
 */
class UserParser extends AbstractParser
{
    /** @var HttpClient */
    private $httpClient;
    
    /**
     * InstagramParser constructor.
     *
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }
    
    public function parse(
        string $username,
        callable $callback = null
    )
    {
        // TODO: ensure user variable is not empty
        // TODO: Build endpoint and make request
        // TODO: Parse user info
        // TODO: Parse each user posts
        // TODO: Construct and return a response User object
    }
}