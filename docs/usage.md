# Usage
Here I'll show you all possible usage of the Instagram Parser library.
> Be careful! I recommend you to enqueue the output result and treat it 
> separately, some of the Tags can have thousands of posts related to.

You can also check out the [examples](https://github.com/mineur/instagram-parser/tree/master/examples) 
folder and execute some of the use cases to test the library.

## Tags Parser
This method will give you all the posts related to the passed tag.
Is mandatory to pass the `queryHash` because this endpoint uses the Facebook's 
GraphQL.
```php
use Mineur\InstagramParser\Instagram;
use Mineur\InstagramParser\Model\InstagramPost;

$queryHash = '298b92c8d7cad703f7565aa892ede943';
Instagram::createTagParser($queryHash)
    ->parse('sun', function(InstagramPost $post) {
        dump($post);
    });
```
- It is not necessary to cast the InstagramPost object if you don't want to.
- You also don't need to get the data via callback, you can just use 
`->parse('tag_name');` to get the returned InstagramPost object.

Then you will only have to access it by is getters. Like so:
```php
//...
->parse('soccer', function($post) {
    echo $post->getComment();
    echo $post->getLikesCount();
    //...
});
```

## User Media Parser
This method will give you all the posts related to a user.
Is mandatory to pass the `queryHash`.
```php
use Mineur\InstagramParser\Instagram;
use Mineur\InstagramParser\Model\InstagramPost;

$queryHash = '298b92c8d7cad703f7565aa892ede943';
$userId = '2014529';
Instagram::createUserMediaParser($queryHash)
    ->parse($userId, function(InstagramPost $post) {
        dump($post);
    });
```

## User Parser
This will give you the user info. In this case you don't need any `queryHash`.
```php
use Mineur\InstagramParser\Instagram;
use Mineur\InstagramParser\Model\User;

$userParser = Instagram::createUserParser();

/** @var User $user */
$user = $userParser->parse('apisearch');

echo $user->getFullName();
```