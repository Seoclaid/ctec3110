<?php // application/app/bootstrap.php

session_start();

/**
 * The entry point to the application.
 * @author Sophie
 */

require_once __DIR__ . 'config.php';

/* set the timezone to UTC as that is the specified timezone for all M2M conversations */
date_default_timezone_set(TIMEZONE);

require_once __DIR__ . 'routes.php';

$router = new Router();
$router->route();