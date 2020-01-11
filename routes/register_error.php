<?php

require_once __DIR__ . '/../routes/wrappers/HTML_Wrapper.php';

$app->get('/reg_missing_value_error', function() use ($app)
{

    $f_app_name = 'EE Register';                              //title name of the current page

    $f_script_name = $_SERVER["SCRIPT_NAME"];                 //current scripts path

    $f_html_wrapper = new HTML_Wrapper();

    $f_header = $f_html_wrapper->get_header();
    $f_html_output = $f_html_wrapper->get_register_input_field_empty_form()['html_output'];
    $f_html_output2 = $f_html_wrapper->get_register_input_field_empty_form()['html_output2'];

    $arr = [                                                  //all values initialised are stored in this array and passed into
        'landing_page' => $f_script_name,                       //the render function along with the php file needed for render
        'header' => $f_header,
        'page_title' => $f_app_name,
        'html_output' => $f_html_output,
        'html_output2' => $f_html_output2,
    ];

    $app->render('display_register_error.php', $arr);

})->name('reg_missing_value_error');

$app->get('/reg_wrong_input_error', function() use ($app)
{

    $f_app_name = 'EE Register';                              //title name of the current page

    $f_script_name = $_SERVER["SCRIPT_NAME"];                 //current scripts path

    $f_html_wrapper = new HTML_Wrapper();

    $f_header = $f_html_wrapper->get_header();
    $f_html_output = $f_html_wrapper->get_register_user_exists_form()['html_output'];
    $f_html_output2 = $f_html_wrapper->get_register_user_exists_form()['html_output2'];

    $arr = [                                                  //all values initialised are stored in this array and passed into
        'landing_page' => $f_script_name,                       //the render function along with the php file needed for render
        'header' => $f_header,
        'page_title' => $f_app_name,
        'html_output' => $f_html_output,
        'html_output2' => $f_html_output2,
    ];

    $app->render('display_register_error.php', $arr);

})->name('reg_wrong_input_error');