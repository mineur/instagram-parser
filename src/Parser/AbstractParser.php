<?php

/*
 * Mineur/instagram-parser package
 *
 * Feel free to contribute!
 *
 * @license MIT
 * @author alexhoma <alexcm.14@gmail.com>
 */

declare(strict_types=1);

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