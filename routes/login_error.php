<?php

require_once __DIR__ . '/../routes/wrappers/HTML_Wrapper.php';

$app->get('/login_missing_value_error', function() use ($app)
{

    $f_app_name = 'EE Login';                                 //title name of the current page

    $f_script_name = $_SERVER["SCRIPT_NAME"];                 //current scripts path

    $f_html_wrapper = new HTML_Wrapper();

    $f_header = $f_html_wrapper->get_header();
    $f_html_output = $f_html_wrapper->get_login_input_field_empty_form()['html_output'];
    $f_html_output2 = $f_html_wrapper->get_login_input_field_empty_form()['html_output2'];

    $arr = [                                                  //all values initialised are stored in this array and passed into
        //the render function along with the php file needed for render
        'header' => $f_header,
        'page_title' => $f_app_name,
        'html_output' => $f_html_output,
        'html_output2' => $f_html_output2,
    ];

    $app->render('display_login_error.php', $arr);

})->name('login_missing_value_error');

$app->get('/login_wrong_input_error', function() use ($app)
{

    $f_app_name = 'EE Login';                                 //title name of the current page

    $f_script_name = $_SERVER["SCRIPT_NAME"];                 //current scripts path

    $f_html_wrapper = new HTML_Wrapper();

    $f_header = $f_html_wrapper->get_header();
    $f_html_output = $f_html_wrapper->get_login_wrong_input_form()['html_output'];
    $f_html_output2 = $f_html_wrapper->get_login_wrong_input_form()['html_output2'];

    $arr = [                                                  //all values initialised are stored in this array and passed into
        //the render function along with the php file needed for render
        'header' => $f_header,
        'page_title' => $f_app_name,
        'html_output' => $f_html_output,
        'html_output2' => $f_html_output2,
    ];

    $app->render('display_login_error.php', $arr);

})->name('login_wrong_input_error');