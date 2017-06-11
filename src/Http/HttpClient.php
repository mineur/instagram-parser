<?php

namespace Mineur\InstagramParser\Http;

interface HttpClient
{
    /**
     * @param string $endpoint
     * @return string
     */
    public function get(string $endpoint): string;
}