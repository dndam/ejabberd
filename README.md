# ejabberd PHP REST API integration

Current implementation aims to integrate Ejabberd within your PHP implementation by using it' new API capabilities.  

Ejabberd already offered a XML RPC, but according to their documentation this will soon be droped in flavor of their newer REST one. Although I searched the entire packagist.org repo, I could only find one (https://github.com/cloudadic/php-ejabberd), which ... isn't the best one: Guzzle is not properly required within composer.json and many code duplication (although it might be good for documentation)  
  
### Installation
```bash
composer require dndam/ejabberd  
composer install
```

### Usage
```php
<?php
  
require __DIR__ . '/vendor/autoload.php';
  
use Ejabberd\Rest\Client;

$client = new Client([
    'apiUrl' => 'http://127.0.0.1:5280/api/',
    'host' => 'chat.example.com'
    ]);
```

### Examples
```php
// Add User
$user = 'mumu';
$password = '123'
$client->createAccount($user, $password);
  
// Add a second User
$user = 'mumu-friend';
$password = '123';
$client->createAccount($user, $password);
  
// Add Roster between the two
$client->addRosterItem('mumu', "mumu-friend"));

```
More examples are placed under **/examples** folder
```bash
php examples/checkStatus.php

```  

## Disclaimer
When started with this wrapper, I was surprised by the lack (or active) support within PHP for XMPP. Most of the libraries were RPC based, which Ejabberd claim to drop its support.  
For this, based on small talks ... arrived to three possibilities:
1. The https://github.com/cloudadic/php-ejabberd style, but their code was the one that started me with this project
2. A Factory pattern, but for someone that is not used with Ejabberd server it' hard to work with and no autocompletion within IDE
3. Proxy: Same as above: no autocomplete
4. Traits: Winner! A lot of wrappers, a lot of methods but we should split them in traits and reuse what we can reuse

