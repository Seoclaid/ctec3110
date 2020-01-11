<?php
$app = new Slim\Slim();
$app->add(new \Slim\Middleware());

require_once __DIR__ . '/../controllers/CsrfGuard.php';