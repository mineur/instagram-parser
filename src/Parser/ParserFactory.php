<?php

namespace Mineur\InstagramParser\Parser;

abstract class ParserFactory
{
    abstract public function parse(
        string $parsedItem,
        callable $callback
    );
}