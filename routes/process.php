<?php

 require_once __DIR__ . '/../controllers/classes/ValidateModel.php';                        //variable information is then used for concatenating with the required
 require_once __DIR__ . '/../routes/wrappers/HTML_Wrapper.php';                       //php files which are required_once and loaded

 $app->get('/process', function() use ($app)
 {
   $f_obj_validate = new ValidateModel();                                 //instantiates the Validation_Model()
   $f_feature = $app->request->get('feature');                            //stores feature value and is validated
   $f_validated_feature = $f_obj_validate->validate_feature($f_feature);

   switch ($f_validated_feature)                                          //a switch is used to check which feature was required
   {                                                                      //then an appropriate call is made to the feature being passed
     case 'login':                                                        //a function is called for that feature that stores details for that feature
     $arr_data = login_form();                                            //along with the correct php file to render
     $feature = 'display_loginpage.php';
     break;
     case 'register':
     $arr_data = register_form();
     $feature = 'display_registerpage.php';
     break;
     case 'download_ee_form':
     $arr_data = download_form();
     $feature = 'display_messageMSISDN.php';
     break;
     case 'review_ee_form':
     $arr_data = review_form();
     $feature = 'display_messageMSISDN.php';
     break;
     default:
     $arr_data = feature_error();
     $feature ='display_global_error.php';
    }

    $app->render($feature, $arr_data);

});

/*
 * Below is the login_form() function that stores the $app array details for
 * redirecting to the correct pages and displaying the correct information
 */

function login_form()
{
  $f_app_name = 'EE Login';                                 //title name of the current page

  $f_script_name = $_SERVER["SCRIPT_NAME"];                 //current scripts path

  $f_html_wrapper = new HTML_Wrapper();

  $f_header = $f_html_wrapper->get_header();
  $f_html_output = $f_html_wrapper->get_login_form()['html_output'];
  $f_html_output2 = $f_html_wrapper->get_login_form()['html_output2'];

  $arr = [                                                  //all values initialised are stored in this array and passed into
                                                            //the render function along with the php file needed for render
    'header' => $f_header,
    'page_title' => $f_app_name,
    'html_output' => $f_html_output,
    'html_output2' => $f_html_output2,
  ];

 return $arr;
}

/*
 * Below is the register_form() function that stores the $app array details for
 * redirecting to the correct pages and displaying the correct information
 */

function register_form()
{

  $f_app_name = 'EE Register';                              //title name of the current page

  $f_script_name = $_SERVER["SCRIPT_NAME"];                 //current scripts path

  $f_html_wrapper = new HTML_Wrapper();

  $f_header = $f_html_wrapper->get_header();
  $f_html_output = $f_html_wrapper->get_register_form()['html_output'];
  $f_html_output2 = $f_html_wrapper->get_register_form()['html_output2'];

  $arr = [                                                  //all values initialised are stored in this array and passed into
    'landing_page' => $f_script_name,                       //the render function along with the php file needed for render
    'header' => $f_header,
    'page_title' => $f_app_name,
    'html_output' => $f_html_output,
    'html_output2' => $f_html_output2,
  ];

 return $arr;
}

/*
 * Below is the download_form() function that stores the $app array details for
 * redirecting to the correct pages and displaying the correct information
 */

function download_form() {

  $f_script_name = $_SERVER["SCRIPT_NAME"];

  $f_app_name = 'EE Download Page';

  $f_html_wrapper = new HTML_Wrapper();

  $f_header = $f_html_wrapper->get_header();
  $f_html_output = $f_html_wrapper->get_download_page();

  $arr = [
    'landing_page' => $f_script_name,
    'header' => $f_header,
    'page_title' => $f_app_name,
    'html_output' => $f_html_output,
  ];

 return $arr;
}

/*
 * Below is the review_form() function that stores the $app array details for
 * redirecting to the correct pages and displaying the correct information
 */

function review_form() {

 $f_script_name = $_SERVER["SCRIPT_NAME"];

 $f_app_name = 'EE Review Page';

 $f_html_wrapper = new HTML_Wrapper();

 $f_header = $f_html_wrapper->get_header();
 $f_html_output = $f_html_wrapper->get_review_page();


 $arr = [
   'landing_page' => $f_script_name,
   'header' => $f_header,
   'page_title' => $f_app_name,
   'html_output' => $f_html_output,
 ];

 return $arr;
}

function feature_error(){
    $f_app_name = 'EE Client - ERROR';                                    //title name of the current page

    $f_html_wrapper = new HTML_Wrapper();

    $f_header = $f_html_wrapper->get_header();
    $f_html_output = $f_html_wrapper->get_global_error_page();


    $arr = [                                                  //all values initialised are stored in this array and passed into
        //the render function along with the php file needed for render
        'header' => $f_header,
        'page_title' => $f_app_name,
        'html_output' => $f_html_output
    ];

    return $arr;
}