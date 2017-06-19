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
use 
use 

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
    ¡Disfruta del sol pero sin quemarte! Con #SunZapper estarás protegido aunque te pases horas dentro del agua. \n
    #zincstick #wevegotyoucovered #dontgetcooked #wearsunscream #cremasolar #spf50 #notequemes #spotferrol
    """
  -commentsCount: 0
  -shortCode: "BVb_QkdhYaC"
  -takenAtTimestamp: "1497695267"
  -dimensions: Mineur\InstagramParser\Model\MediaDimensions {#31
    -height: 1079
    -width: 1080
  }
  -likesCount: 21
  -mediaSrc: "https://scontent-mrs1-1.cdninstagram.com/t51.2885-15/e35/19228916_1933711906908451_8560357222406684672_n.jpg"
  -thumbnailSrc: "https://scontent-mrs1-1.cdninstagram.com/t51.2885-15/s640x640/sh0.08/e35/c0.0.1079.1079/19228916_1933711906908451_8560357222406684672_n.jpg"
  -ownerId: "1103553924"
  -video: false
  -commentsDisabled: false
}
```
Then you will only have to access it by is getters. Like so:
```php
$post->getId();
```