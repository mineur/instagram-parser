<?php

// Autoload composer
require_once __DIR__ . '/../vendor/autoload.php';

use Mineur\InstagramParser\Instagram;
use Mineur\InstagramParser\Model\InstagramPost;

// Make sure you get your own queryHash
// this one may not work for you
$queryHash = '472f257a40c653c64c666ce877d59d2b';

// Be sure this is the User ID, not the Username
// Otherwise program will fail
$userId = '19318909';

Instagram::createUserMediaParser($queryHash)
    ->parse($userId, function(InstagramPost $post) {
        dump($post);
    }
);