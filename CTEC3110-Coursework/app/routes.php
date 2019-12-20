<?php

require 'routes/homepage.php';
//require 'routes/loggers/monolog.php';

$app->get('/home', function($request, $response)
{
    return $this->view->render($response, 'homepageform.html.twig');
});