<?php

namespace Mineur\InstagramParser;

use Mineur\InstagramParser\Parser\TagParser;

class Instagram
{
    public static function createTagParser($httpClient)
    {
        return new TagParser($httpClient);
    }
}