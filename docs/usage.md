# Usage
Here I'll show you all possible usage of the Instagram Parser library.
> Be careful! I recommend you to enqueue the output result and treat it 
> separately, some of the Tags can have thousands of posts related to.

## Tags Parser
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
Is mandatory to pass the `queryId`.
```php
use Mineur\InstagramParser\Instagram;
use Mineur\InstagramParser\Model\InstagramPost;

$queryId = '17882293912014529';
$userId = '2014529';
Instagram::createUserMediaParser($queryId)
    ->parse($userId, function(InstagramPost $post) {
        dump($post);
    });
```

## User Parser
This will give you the user info. In this case you don't need any `queryId`.
```php
use Mineur\InstagramParser\Instagram;
use Mineur\InstagramParser\Model\User;

Instagram::createUserParser()
    ->parse('github', function(User $user) {
        echo $user->getFullName();
    });
```