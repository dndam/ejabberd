<?php

require __DIR__ . '/../vendor/autoload.php';

use Ejabberd\Rest\Client;

$client = new Client([
    'apiUrl' => 'http://127.0.0.1:5280/api/',
    'host' => 'chat.example.com'
    ]);
$client->createAccount('123', "123456789asd");
