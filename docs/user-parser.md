# User Parser
This will give you the user info. In this case you don't need any `queryId`.
```php
use Mineur\InstagramParser\Instagram;
use Mineur\InstagramParser\Model\User;

Instagram::createUserParser()
    ->parse('github', function(User $user) {
        echo $user->getFullName();
    });
```

## User object
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