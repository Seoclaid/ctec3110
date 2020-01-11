<?php

require_once __DIR__ . '/../controllers/classes/LogoutModel.php'; //variable information is then used for concatenating with the required                          //php files which are required_once and loaded

require_once __DIR__ . '/../routes/wrappers/Session_Wrapper.php';
require_once __DIR__ . '/../routes/wrappers/MCrypt_Wrapper.php';
require_once __DIR__ . '/../routes/wrappers/MySQL_Wrapper.php';
require_once __DIR__ . '/../controllers/classes/AppLoggerModel.php';

$app->get('/logout', function() use ($app)
{
    //Logger initialisation
    $f_obj_mcrypt_wrapper = new MCrypt_Wrapper();
    $f_obj_mcrypt_wrapper->initialise_mcrypt_encryption();
    $f_userID = $f_obj_mcrypt_wrapper->decrypt(Session_Wrapper::get_session('username'));


    $f_obj_MySQL = new MySQL_Wrapper();
    $f_obj_MySQL->connect_to_database();

    $f_obj_logger= new AppLoggerModel();
    $f_obj_logger->set_database_handle($f_obj_MySQL);
    $f_obj_logger->do_get_database_connection_result();
    $f_obj_logger->do_logging($f_userID,'logout');


    if(logout())
    { //checks the function logout() value for true or false
        $f_obj_logger->do_logging($f_userID,'user logged out successfully');
        session_regenerate_id(true);	//regenerates session id's, keeps current information with new id                                                              //if true then the user redirected to the authentication page
        $app->response->redirect($app->urlFor('authentication'));     //else an error is thrown

    }else {
        $f_obj_logger->do_logging($f_userID,'error while logging out');
        return $app->redirect('error'); //in case logout does not work
    }

})->name('logout');

/*
 * logout() initialises the LogoutModel() and uses the method to log the user out
 * a boolean value is returned to ensure the success of the logging out
 */

function logout() {
    $f_obj_logout = new LogoutModel();
    $f_boolean_logout = $f_obj_logout->do_logout();

    return $f_boolean_logout;
}