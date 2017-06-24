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

namespace Mineur\InstagramParser\Http;

interface HttpClient
{
    /**
     * @param string $endpoint
     * @return string
     */
    public function get(string $endpoint): string;
}