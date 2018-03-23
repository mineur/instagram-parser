<?php

// Autoload composer
require_once __DIR__ . '/../vendor/autoload.php';

use Mineur\InstagramParser\Instagram;
use Mineur\InstagramParser\Model\User;

Instagram::createUserParser()
    ->parse('github', function(User $user) {
        echo $user->toArray();
    }
);