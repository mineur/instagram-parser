<?php

// Autoload composer
require_once __DIR__ . '/../vendor/autoload.php';

use Mineur\InstagramParser\Instagram;
use Mineur\InstagramParser\Model\User;

$userParser = Instagram::createUserParser();

/** @var User $user */
$user = $userParser->parse('apisearch');

dump($user->toArray());