Instagram Parser
=================
Initial release of an Instagram website parser. It acts like an API, but 
crawling the web.

## Installation
```shell
composer require mineur/instagram-parser:dev-master
```

## Basic initialization
Instantiate the GuzzleHttpClient adapter with just a query ID! :)

```php
use Mineur\InstagramParser\Http\GuzzleHttpClient;
use Mineur\InstagramParser\Instagram;

$httpClient = new GuzzleHttpClient('17882293912014529');
Instagram::createTagParser($httpClient)
    ->parse('cremasolar');
```

### Callback
```php
$httpClient = new GuzzleHttpClient('17882293912014529');
Instagram::createTagParser($httpClient)
    ->parse('cremasolar', function($post) {
        dump($post);
    });
```

## Returned Object
Once you run the parser in your console, you will get an object similar the next one:
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
    //..
    ->parse('cremasolar', function($post) {
        dump($post->getComment());
    });
```

## TODO:
- Parse tags from the comment string and add it as an array on a object property named `tag`.
- Test it using phpunit.