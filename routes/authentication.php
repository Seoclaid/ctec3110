<?php
// application/app/routes/authentication.php

require_once __DIR__ . 'wrappers/HTML_Wrapper.php';

$app->get('/', function() use ($app)
{

$f_html_wrapper = new HTML_Wrapper();

$f_script_name = $_SERVER["SCRIPT_NAME"];                 //current scripts path

$f_app_name = 'EE Client';                                //title name of the current page

$f_header = $f_html_wrapper->get_header();
$f_html_output = $f_html_wrapper->get_authentication_page_form();

$arr = [                                                  //all values initialised are stored in this array and passed into
'landing_page' => $f_script_name,                       //the render function along with the php file needed for render
'header' => $f_header,
'page_title' => $f_app_name,
'html_output' => $f_html_output,
];

$app->render('display_authenticationpage.php', $arr);
})->name('authentication');