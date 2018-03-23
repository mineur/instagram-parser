Instagram Parser
=================
[![License](https://poser.pugx.org/mineur/instagram-parser/license)](https://packagist.org/packages/mineur/instagram-parser)
[![Build Status](https://travis-ci.org/mineur/twitter-stream-api.svg?branch=master)](https://travis-ci.org/mineur/twitter-stream-api)
[![Code Climate](https://codeclimate.com/github/mineur/instagram-parser/badges/gpa.svg)](https://codeclimate.com/github/mineur/instagram-parser)
[![Latest Unstable Version](https://poser.pugx.org/mineur/instagram-parser/v/unstable)](https://packagist.org/packages/mineur/instagram-parser)
[![Total Downloads](https://poser.pugx.org/mineur/instagram-parser/downloads)](https://packagist.org/packages/mineur/instagram-parser)

The Instagram parser gives you an easy interface to parse all the Instagram's
data. Like an API, but without being it! You can get posts by a tag, all user posts 

## Setup
```shell
composer require mineur/instagram-parser:dev-master
```
Before run your parsers, you first need a **query ID**. Follow this 5 steps to 
get yours: [How to get a query ID](/docs/setup.md#how-to-get-your-query-id).

## Start parsing!
Let's parse all data tagged with the string "github" for instance. You will get a scaled infinite 
loop of posts related to it until they are finished.
```php
use Mineur\InstagramParser\Instagram;
use Mineur\InstagramParser\Model\InstagramPost;

$queryHash = '17882293912014529';

Instagram::createTagParser($queryHash)
    ->parse('github', function(InstagramPost $post) {
        dump($post);
    });
```
### The console dump will be like this:
![](http://thumbs.gfycat.com/SpiritedAlarmedCopepod-size_restricted.gif)


## Motivation
Since Instagram has restricted its API only to registered and verified applications, 
you can't get all of its public data being an experimental user or a data science 
analyst who just wants to play with that, you only have access to the API sandbox mode.

So I decided to create an alternative parser on top of GuzzleHttp library to access 
to the entire data with a nice interface.

## Documentation
For more information about this library [see the docs](/docs/index.md).
