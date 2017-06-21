Instagram Parser
=================
[![License](https://poser.pugx.org/mineur/instagram-parser/license)](https://packagist.org/packages/mineur/instagram-parser)
[![Build Status](https://travis-ci.org/mineur/twitter-stream-api.svg?branch=master)](https://travis-ci.org/mineur/twitter-stream-api)
[![Code Climate](https://codeclimate.com/github/mineur/instagram-parser/badges/gpa.svg)](https://codeclimate.com/github/mineur/instagram-parser)
[![Latest Unstable Version](https://poser.pugx.org/mineur/instagram-parser/v/unstable)](https://packagist.org/packages/mineur/instagram-parser)
[![Total Downloads](https://poser.pugx.org/mineur/instagram-parser/downloads)](https://packagist.org/packages/mineur/instagram-parser)

The Instagram web parser. It just works like a simple API, but without being 
an API. It crawls the Intagram web responses and gives you an easy interface 
to work with the data. 

## Setup
1. Install with composer:
```shell
composer require mineur/instagram-parser:dev-master
```
2. Go to `http://www.instagram.com/github/`, we need a Query ID.
<img src="/docs/img/github-page.png" alt="Instagram Github page">
3. The go to `Web inspector > Network`.
4. Scroll down the page and click on **Load more** blue button.
<img src="/docs/img/load-more.png" alt="Instagram load more">
5. Take a look at the following xhr query:
<img src="/docs/img/xhr-queries.png" alt="Instagram xhr queries">
6. Copy the param `query_id` like so, and keep it to build the parser.
<img src="/docs/img/query-id.png" alt="Instagram xhr queries">

## Start parsing!
You've got it! just pass your query ID. And you will not have to worry about 
this ID anymore.
```php
use Mineur\InstagramParser\Instagram;
use Mineur\InstagramParser\Model\InstagramPost;

$queryId = '17882293912014529';
Instagram::createTagParser($queryId)
    ->parse('messi', function(InstagramPost $post) {
        echo $post->getContent();
    });
```
> You don't need to cast InstagramPost if you don't want to.
> It is just to easy work with your IDE's autocomplete.
