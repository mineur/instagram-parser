Instagram Parser
=================
[![License](https://poser.pugx.org/mineur/instagram-parser/license)](https://packagist.org/packages/mineur/instagram-parser)
[![Build Status](https://travis-ci.org/mineur/twitter-stream-api.svg?branch=master)](https://travis-ci.org/mineur/twitter-stream-api)
[![Code Climate](https://codeclimate.com/github/mineur/instagram-parser/badges/gpa.svg)](https://codeclimate.com/github/mineur/instagram-parser)
[![Latest Unstable Version](https://poser.pugx.org/mineur/instagram-parser/v/unstable)](https://packagist.org/packages/mineur/instagram-parser)
[![Total Downloads](https://poser.pugx.org/mineur/instagram-parser/downloads)](https://packagist.org/packages/mineur/instagram-parser)

Initial release of an Instagram website parser. It acts like an API, but 
crawling the web.


## Installation
```shell
composer require mineur/instagram-parser:dev-master
```

## Initialization
The Instagram Factory class gives you the following methods to retrieve the 
different Instagram web resources:

### Tags Parser
This method will give you all the posts related to the passed tag.
Is mandatory to pass the `queryId` because this endpoint uses the Facebook's 
GraphQL.
```php
use Mineur\InstagramParser\Instagram;
use Mineur\InstagramParser\Model\InstagramPost;

$queryId = '17882293912014529';
Instagram::createTagParser($queryId)
    ->parse('sun', function(InstagramPost $post) {
        dump($post);
    });
```
- It is not necessary to cast the InstagramPost object if you don't want to.
- You also don't need to get the data via callback, you can just use 
`->parse('tag_name');` to get the returned InstagramPost object.

#### InstagramPost object
Once you run the tags parser in your console, you will get an infinite bunch of
objects similar to this one:
```php
Mineur\InstagramParser\Model\InstagramPost {#36
  -id: 1539101913268979330
  -comment: """
    ¡Disfruta del sol pero sin quemarte! #wearsunscream #cremasolar
    """
  -commentsCount: 0
  -shortCode: "BVb_QkdhaC"
  -takenAtTimestamp: "149769267"
  -dimensions: Mineur\InstagramParser\Model\MediaDimensions {#31
    -height: 1079
    -width: 1080
  }
  -likesCount: 21
  -mediaSrc: "https://scontent-mrs1-1.cdnins/672_n.jpg"
  -thumbnailSrc: "https://cdninstagr.am/84672_n.jpg"
  -ownerId: "1103553924"
  -video: false
  -commentsDisabled: false
}
```
Then you will only have to access it by is getters. Like so:
```php
//...
->parse('soccer', function($post) {
    echo $post->getComment();
    echo $post->getLikesCount();
    //...
});
```
> Be careful! I recommend you to enqueue the output result and treat it 
> separately, some of the Tags can have thousands of posts related to.

### User Parser
This will give you the user info. In this case you don't need any `queryId`.
```php
use Mineur\InstagramParser\Instagram;
use Mineur\InstagramParser\Model\User;

Instagram::createUserParser()
    ->parse('github', function(User $user) {
        echo $user->getFullName();
    });
```

#### User object
Once you run the parser you will get a Uer object like this one:
```php
Mineur\InstagramParser\Model\User {#33
  -id: "182889088"
  -username: "alexcm14"
  -fullName: "Alex Casajuana"
  -biography: "Software craftsman apprentice"
  -follows: 19
  -followedBy: 12
  -externalUrl: null
  -countryBlock: false
  -isPrivate: false
  -isVerified: true
  -profilePictureUrl: "https://insta.gram.net/t870_a.jpg"
  -profilePictureUrlHd: "https://insta.gram.net/t8x70_a.jpg"
  -connectedFacebookPage: null
  -media: array:12 [
      // user media array
  ]
```

## TODO:
- Parse tags from the comment string and add it as an array on a object 
property named `tag`.
- Tags Streaming parser.
- Parse multiple tags at once.
- Test it using phpunit.
- Geolocation parser and Geolocation streaming parser.
