<?php

/*
 * Mineur/instagram-parser package
 *
 * Feel free to contribute!
 *
 * @license MIT
 * @author alexhoma <alexcm.14@gmail.com>
 */

namespace Mineur\InstagramParser;

use Mineur\InstagramParser\Http\GuzzleHttpClient;
use Mineur\InstagramParser\Model\QueryHash;
use Mineur\InstagramParser\Parser\LocationParser;
use Mineur\InstagramParser\Parser\TagParser;
use Mineur\InstagramParser\Parser\UserMediaParser;
use Mineur\InstagramParser\Parser\UserParser;

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
     * @param string $queryHash
     * @return TagParser
     */
    public static function createTagParser(string $queryHash)
    {
        return new TagParser(
            new GuzzleHttpClient(),
            new QueryHash($queryHash)
        );
    }
    
    /**
     * Instagram Location parser
     *
     * @param string $queryHash
     * @return LocationParser
     */
    public static function createLocationParser(string $queryHash)
    {
        return new LocationParser(
            new GuzzleHttpClient(),
            new QueryHash($queryHash)
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
     * @param string $queryHash
     * @return UserMediaParser
     */
    public static function createUserMediaParser(string $queryHash)
    {
        return new UserMediaParser(
            new GuzzleHttpClient(),
            new QueryHash($queryHash)
        );
    }
}