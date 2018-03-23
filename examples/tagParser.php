<?php

// Autoload composer
require_once __DIR__ . '/../vendor/autoload.php';

use Mineur\InstagramParser\Instagram;
use Mineur\InstagramParser\Model\InstagramPost;

// Make sure you get your own queryHash
// this one may not work for you
$queryHash = '298b92c8d7cad703f7565aa892ede943';

Instagram::createTagParser($queryHash)
    ->parse('github', function(InstagramPost $post) {
        dump($post);
    }
);