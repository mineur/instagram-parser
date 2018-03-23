<?php

// Autoload composer
require_once __DIR__ . '/../vendor/autoload.php';

use Mineur\InstagramParser\Instagram;
use Mineur\InstagramParser\Model\InstagramPost;

$queryId = '17882293912014529';

Instagram::createTagParser($queryId)
    ->parse('github', function(InstagramPost $post) {
        dump($post);
    }
);