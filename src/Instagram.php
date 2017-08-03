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
     * Instagram Location parser
     *
     * @param string $queryId
     * @return LocationParser
     */
    public static function createLocationParser(string $queryId)
    {
        return new LocationParser(
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