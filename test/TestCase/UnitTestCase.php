<?php

/*
 * Mineur/instagram-parser package
 *
 * Feel free to contribute!
 *
 * @license MIT
 * @author alexhoma <alexcm.14@gmail.com>
 */

namespace Mineur\TwitterStreamApiTest\TestCase;

use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

abstract class UnitTestCase extends TestCase
{
    protected function mock(string $class): MockInterface
    {
        return Mockery::mock($class);
    }
}