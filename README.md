Instagram Parser
=================
[![License](https://poser.pugx.org/mineur/instagram-parser/license)](https://packagist.org/packages/mineur/instagram-parser)
[![Build Status](https://travis-ci.org/mineur/twitter-stream-api.svg?branch=master)](https://travis-ci.org/mineur/twitter-stream-api)
[![Code Climate](https://codeclimate.com/github/mineur/instagram-parser/badges/gpa.svg)](https://codeclimate.com/github/mineur/instagram-parser)
[![Latest Unstable Version](https://poser.pugx.org/mineur/instagram-parser/v/unstable)](https://packagist.org/packages/mineur/instagram-parser)
[![Total Downloads](https://poser.pugx.org/mineur/instagram-parser/downloads)](https://packagist.org/packages/mineur/instagram-parser)

The Instagram web parser gives you an easy interface to parse the Instagram's
data. Like if it was an API, but without being it! 

You can get posts related to a tag and all user posts, including its personal 
info. And more features are comming...

## Setup
```shell
composer require mineur/instagram-parser:dev-master
```
Before run your parsers, you first need a **query ID**. Follow this 5 steps to 
get yours: [How to get a query ID](/docs/how-to-get-your-query-id.md).

## Start parsing!
```php
use Mineur\InstagramParser\Instagram;
use Mineur\InstagramParser\Model\InstagramPost;

$queryId = '17882293912014529';

Instagram::createTagParser($queryId)
    ->parse('messi', function(InstagramPost $post) {
        echo $post->getContent();
    });
```
> You don't need to cast **InstagramPost** if you don't want to.
> It is just to easy work with your IDE's autocomplete.

> Be careful! I recommend you to enqueue the output result and treat it separately, 
> some of the Tags can have thousands of posts related to.
