<?php

require '/../vendor/autoload.php';

$app_dir = dirname(__DIR__) . '/CTEC3110-Coursework/app/';
$settings = require $app_dir . 'settings.php';
$dependencies = require $app_dir . 'dependencies.php';
$routes = require $app_dir . 'routes.php';

if (function_exists('xdebug_start_trace'))
{
    xdebug_start_trace();
}

$container = new \Slim\Container($settings);

$app = new \Slim\App($container);

$app->run();

if (function_exists('xdebug_stop_trace'))
{
    xdebug_stop_trace();
}