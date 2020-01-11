<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function(Request $request, Response $response) use ($app)
{

    $sid = session_id();
    if(!isset($_SESSION['username'])) {                                  //if the SESSION is not set than the user is not logged in
        $app->response->redirect($app->urlFor('authentication'));        //therefore the page does not get displayed
    }else {

        /*
         * if the SESSION is available then the MyCrypt_Wrapper() is inistantiated
         * with this, the logged in username is usually encrypted so to display it on the homepage
         * it is first decrypted then passed into the $app array to configure the settings
         */

        $f_obj_mcrypt_wrapper = new MCrypt_Wrapper();
        $f_obj_mcrypt_wrapper->initialise_mcrypt_encryption();

        $f_admin = $f_obj_mcrypt_wrapper->decrypt(Session_Wrapper::get_session('username'));

        $f_app_name = 'EE Client - Home';                                    //title name of the current page

        $f_script_name = $_SERVER["SCRIPT_NAME"];                            //current scripts path

        $f_html_wrapper = new HTML_Wrapper();

        $f_header = $f_html_wrapper->get_header();
        $f_html_output = $f_html_wrapper->get_homepage_page_form()['html_output'];
        $f_html_output2 = $f_html_wrapper->get_homepage_page_form()['html_output2'];

        $arr = [
            'landing_page' => $f_script_name,                                 //all values initialised are stored in this array and passed into
            'admin' => 'Hello, ' . $f_admin,                                  //the render function along with the php file needed for render
            'header' => $f_header,
            'page_title' => $f_app_name,
            'html_output' => $f_html_output,
            'html_output2' => $f_html_output2,
        ];

        $app->render('display_homepage.php', $arr);
    }
})->name('homepage');

/**
 * function processOutput($app, $html_output)
 * {
 * $process_output = $app->getContainer()->get('processOutput');
 * $html_output = $process_output->processOutput($html_output);
 * return $html_output;
 * }
*/
    $app->get('/homepage_error', function() use ($app)
    {
        if(!isset($_SESSION['username'])) {                                  //if the SESSION is not set than the user is not logged in
            $app->response->redirect($app->urlFor('authentication'));        //therefore the page does not get displayed
        }else {

            /*
             * if the SESSION is available then the MyCrypt_Wrapper() is inistantiated
             * with this, the logged in username is usually encrypted so to display it on the homepage
             * it is first decrypted then passed into the $app array to configure the settings
             */

            $f_obj_mcrypt_wrapper = new MCrypt_Wrapper();
            $f_obj_mcrypt_wrapper->initialise_mcrypt_encryption();

            $f_admin = $f_obj_mcrypt_wrapper->decrypt(Session_Wrapper::get_session('username'));

            $f_app_name = 'EE Client - Home';                                    //title name of the current page

            $f_script_name = $_SERVER["SCRIPT_NAME"];                            //current scripts path

            $f_html_wrapper = new HTML_Wrapper();

            $f_header = $f_html_wrapper->get_header();
            $f_html_output = $f_html_wrapper->get_homepage_page_error_form()['html_output'];
            $f_html_output2 = $f_html_wrapper->get_homepage_page_error_form()['html_output2'];

            $arr = [
                'landing_page' => $f_script_name,                                 //all values initialised are stored in this array and passed into
                'admin' => 'Hello, ' . $f_admin,                                  //the render function along with the php file needed for render
                'header' => $f_header,
                'page_title' => $f_app_name,
                'html_output' => $f_html_output,
                'html_output2' => $f_html_output2,
            ];

            $app->render('display_homepage.php', $arr);
        }
    })->name('homepage_error');
