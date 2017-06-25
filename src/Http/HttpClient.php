<?php

/*
 * Mineur/instagram-parser package
 *
 * Feel free to contribute!
 *
 * @license MIT
 * @author alexhoma <alexcm.14@gmail.com>
 */

namespace Mineur\InstagramParser\Http;

interface HttpClient
{
    /**
     * @param string $endpoint
     * @return string
     */
    public function get(string $endpoint): string;
}