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


## Parsers
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

> Be careful! I recommend you to enqueue the output result and treat it 
> separately, some of the Tags can have thousands of posts related to.

### User Parser
This will give you the user info plus all posts of this user. And

## InstagramPost object
Once you run the parser in your console, you will get an object similar 
the next one:
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

## TODO:
- Parse tags from the comment string and add it as an array on a object 
property named `tag`.
- Parse multiple elements at once.
- Test it using phpunit.