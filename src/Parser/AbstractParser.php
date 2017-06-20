<?php

namespace Mineur\InstagramParser\Parser;

/**
 * Class AbstractParser
 *
 * @package Mineur\InstagramParser\Parser
 */
abstract class AbstractParser
{
    abstract public function parse(
        string $parsedItem,
        callable $callback
    );
}