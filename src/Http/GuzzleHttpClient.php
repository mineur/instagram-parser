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
     * @param array  $options
     * @return string
     */
    public function get(string $endpoint, array $options): string
    {
        $clientResponse = $this->client->get(
            self::BASE_INSTAGRAM_ENDPOINT . $endpoint,
            $options
        );
        
        return $clientResponse->getBody()->getContents();
    }
}