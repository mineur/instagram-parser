<?php

namespace Mineur\InstagramApi\Http;

interface HttpClient
{
    public function get(string $url);
}