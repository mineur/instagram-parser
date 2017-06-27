# The response objects
In this section you will se the kind of output you will receive once you run the 
parsers.

## Instagram Post object
Every parser that returns instagram posts will give you an object like this one: 
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
Then you will be able to access it using the following ways:
- Using the class getters:
```php
$post->getComment();
```
- Transforming the object to an array:
```php
$aPost = $post->toArray();
$aPost['comment'];
```
- Serializing the object:
```php
$post->serialize();
```

## User object
Same happens with the User object. Once you run the User Parser, the output will 
be an object like this one:
```php
Mineur\InstagramParser\Model\User {#33
  -id: "182889088"
  -username: "alexhoma"
  -fullName: "Alex"
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
}
```
You will be able to access it using the following ways:
- Using the class getters:
```php
$user->getFullName();
```
- Transforming the object to an array:
```php
$aUser = $user->toArray();
$aUser['full_name'];
```
- Serializing the object:
```php
$user->serialize();
```