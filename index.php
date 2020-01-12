<?php // application/index.php
declare(strict_types=1);

/**
 * Created in PhpStorm
 * @author P16217148 Sophie Rochester Wigmore
 * @author P******** Sakshi
 * @author P******** Tanya
 * Date: 1/10/2019
 *
 * As this is a public element that will call the bootstrap which in turn will determine the routes, this is kept minimalistic.
 * It is a PHP application that implements a soap client and retrieve messages from the EE server and are displayed to the user
 */

ini_set('display_errors', 'On');
ini_set('html_errors', 'On');
ini_set('xdebug.trace_output_name', 'secure_app.%t');

\Slim\Slim::registerAutoloader(); //could imply "require 'vendor/autoloader.php'", however this seems to return composer errors...

if (function_exists('xdebug_start_trace'))
{
    xdebug_start_trace();
}
require_once 'app/bootstrap.php';
require_once 'Slim/Slim.php';

session_save_path(__DIR__ . 'temp/session');
session_start();

/**
 * @var bool $displayErrorDetails
 */

$displayErrorDetails = $container->get('settings')['displayErrorDetails'];

if (function_exists('xdebug_stop_trace'))
{
    xdebug_stop_trace();
}
