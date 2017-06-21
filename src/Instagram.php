<?php

namespace Mineur\InstagramParser;

use Mineur\InstagramParser\Http\GuzzleHttpClient;
use Mineur\InstagramParser\Parser\TagParser;
use Mineur\InstagramParser\Parser\UserParser;
use Mineur\InstagramParser\Parser\UserMediaParser;

/**
 * Class Instagram
 * Factory class to create Instagram parsers
 *
 * @package Mineur\InstagramParser
 */
class Instagram
{
    /**
     * Instagram Tags parser
     *
     * @param string $queryId
     * @return TagParser
     */
    public static function createTagParser(string $queryId)
    {
        return new TagParser(
            new GuzzleHttpClient(),
            $queryId
        );
    }
    
    /**
     * User media parser
     *
     * @return UserParser
     */
    public static function createUserParser()
    {
        return new UserParser(
            new GuzzleHttpClient()
        );
    }
    
    /**
     * @param string $queryId
     * @return UserMediaParser
     */
    public static function createUserMediaParser(string $queryId)
    {
        return new UserMediaParser(
            new GuzzleHttpClient(),
            $queryId
        );
    }
}