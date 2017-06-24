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

use GuzzleHttp\Client;

class GuzzleHttpClient implements HttpClient
{
    const BASE_INSTAGRAM_ENDPOINT = 'https://www.instagram.com';
    
    /** @var Client */
    private $client;
    
    /**
     * GuzzleHttpClient constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }
    
    /**
     * @param string $endpoint
     * @return string
     */
    public function get(string $endpoint): string
    {
        $clientResponse = $this->client->get(
            self::BASE_INSTAGRAM_ENDPOINT . $endpoint
        );

        return $clientResponse->getBody();
    }
}