<?php

namespace Mineur\InstagramParser;

use Mineur\InstagramParser\Parser\TagParser;

/**
 * Class Instagram
 * Factory class to create Instagram parsers
 *
 * @package Mineur\InstagramParser
 */
class Instagram
{
    public static function createTagParser($httpClient)
    {
        return new TagParser($httpClient);
    }
}