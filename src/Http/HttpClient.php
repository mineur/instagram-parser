<?php

namespace Mineur\InstagramParser\Http;

interface HttpClient
{
    public function get(string $endpoint);
}