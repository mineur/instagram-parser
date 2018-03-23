<?php

// Autoload composer
require_once __DIR__ . '/../vendor/autoload.php';

use Mineur\InstagramParser\Instagram;
use Mineur\InstagramParser\Model\InstagramPost;

// Make sure you get your own queryHash
// this one may not work for you
$queryHash = '951c979213d7e7a1cf1d73e2f661cbd1';

// Be sure this is a Location ID
// Otherwise program will fail
$locationId = '213100244';

Instagram::createLocationParser($queryHash)
    ->parse($locationId, function(InstagramPost $post) {
        dump($post);
    }
);