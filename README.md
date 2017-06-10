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
$httpClient = new GuzzleHttpClient('17882293912014529');
InstagramParser::open($httpClient)
    ->searchFor([
        'messi'
    ])
    ->parse();
```