<?php

namespace Mineur\InstagramParser\Parser;

use Mineur\InstagramParser\Http\HttpClient;

/**
 * Class AbstractParser
 *
 * @package Mineur\InstagramParser\Parser
 */
abstract class AbstractParser
{
    abstract public function __construct(HttpClient $httpClient);
    
    abstract public function parse(
        string $parsedItem,
        callable $callback
    );
}