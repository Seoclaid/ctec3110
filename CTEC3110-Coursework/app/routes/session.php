<?php
$app = new Slim\Slim();
$app->add(new \Slim\Extra\Middleware\CsrfGuard());

require_once 'CsrfGuard.php';