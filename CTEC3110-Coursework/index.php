<?php

ini_set('display_errors', 'On');
ini_set('html_errors', 'On');
ini_set('xdebug.trace_output_name', 'secure_app.%t');

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/*
* Declaring which attributes to the site to call, keeping index.php as minimalistic as possible.
*/

require '/../vendor/autoloader.php';

$app_dir = dirname(__DIR__) . '/CTEC3110-Coursework/app/';
$routes = require $app_dir . 'routes.php';

$app->run();
