# ejabberd PHP REST API integration

Current implementation aims to integrate Ejabberd within your PHP implementation by using it' new API capabilities.  

Ejabberd already offered a XML RPC, but according to their documentation this will soon be droped in flavor of their newer REST one. Although I searched the entire packagist.org repo, I could only find one (https://github.com/cloudadic/php-ejabberd), which ... isn't the best one: Guzzle is not properly required within composer.json and many code duplication (although it might be good for documentation)  
  
### Installation
```bash
composer require dndam/ejabberd
```

### Usage
```php
<?php
  
require __DIR__ . '/vendor/autoload.php';
  
use Ejabberd\Rest;



```

### Examples
```php

```  

