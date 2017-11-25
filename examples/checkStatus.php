<?php


require __DIR__ . '/../vendor/autoload.php';

use Ejabberd\Rest\Client;

$client = new Client(['apiUrl' => 'http://127.0.0.1:5280/api/']);
$client->status();
