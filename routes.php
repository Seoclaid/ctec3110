<?php // app/routes/routes.php

require 'routes/homepage.php';
//require 'routes/loggers/monolog.php';

/**
 * Creating a block of required attributes to the application,
 * this is required from Index -> Bootstrap -> Routes.
 */

require 'routes/authentication.php';
require 'routes/homepage.php';
require 'routes/login.php';
require 'routes/logout.php';
require 'routes/register.php';
require 'routes/processes.php';
require 'routes/download_data.php';
require 'routes/display_information.php';
require 'routes/error.php';
require 'routes/login_error.php';
require 'routes/register_error.php';
require 'routes/display_error.php';
require 'routes/download_error.php';

require_once __DIR__ . '/controllers/LoginController.php';
require_once __DIR__ . '/controllers/LogoutController.php';
require_once __DIR__ . '/controllers/RegisterController.php';
require_once __DIR__ . '/controllers/StatusesController.php';
require_once __DIR__ . '/controllers/UpdatesController.php';

require_once __DIR__ . '/routes/models/ErrorModel.php';
require_once __DIR__ . '/routes/models/LoggedInModel.php';
require_once __DIR__ . '/routes/models/LoginModel.php';
require_once __DIR__ . '/routes/models/LogoutModel.php';
require_once __DIR__ . '/routes/models/RegisterModel.php';
require_once __DIR__ . '/routes/models/RegisteredModel.php';
require_once __DIR__ . '/routes/models/StatusesModel.php';
require_once __DIR__ . '/routes/models/UpdatesModel.php';

require_once __DIR__ . '/routes/views/DebugView.php';
require_once __DIR__ . '/routes/views/ErrorView.php';
require_once __DIR__ . '/routes/views/IndexView.php';
require_once __DIR__ . '/routes/views/LoggedInView.php';
require_once __DIR__ . '/routes/views/LoginView.php';
require_once __DIR__ . '/routes/views/LogoutView.php';
require_once __DIR__ . '/routes/views/RegisteredView.php';
require_once __DIR__ . '/routes/views/RegisterView.php';
require_once __DIR__ . '/routes/views/StatusesView.php';
require_once __DIR__ . '/routes/views/UpdatesView.php';

/**
 * Follows the route to generate a webpage given a specific path.
 */
final class routes
{
    /**
     * The path identifier.
     * @var string
     */
    private $path = 'index';

    /**
     * Creates a new {@link Router}.
     */
    public function __construct()
    {
        if (isset($_GET['action'])) {
            $this->path = $_GET['action'];
        }
    }

    /**
     * Checks whether a user is logged into this session.
     * @return bool {@code true} if so, {@code false} otherwise.
     */
    private function isLoggedIn()
    {
        return isset($_SESSION) && isset($_SESSION['username']) && isset($_SESSION['rank']);
    }

    /**
     * Follows a route and produces a web page from it.
     */
    public function route()
    {
        $view = null;
        $exception = null;

        /* construct template engine */
        $smarty = new Smarty();
        $smarty->caching = true;
        $smarty->cache_lifetime = 120;
        $smarty->setTemplateDir(__DIR__ . '/layouts');
        $smarty->setCompileDir(__DIR__ . '/../../smarty/compiled_templates');
        $smarty->setCacheDir(__DIR__ . '/../../smarty/cache');

        switch ($this->path) {
            case 'index':
                $view = new IndexView($smarty);
                break;

            case 'statuses':
                if (!$this->isLoggedIn()) {
                    $exception = new Exception('You must be <a href="?action=login">logged in<a> to view the circuit board status list.');
                    break;
                }

                $view = new StatusesView($smarty);
                $model = new StatusesModel($view);
                $controller = new StatusesController($model);

                try {
                    $controller->fetchStatuses();
                } catch (Exception $e) {
                    $exception = $e;
                }
                break;

            case 'updates':
                if (!$this->isLoggedIn() || $_SESSION['rank'] != 'ADMIN') {
                    $exception = new Exception('You must be <a href="?action=login">logged in<a> to an administrator\'s account to poll the service for updates.');
                    break;
                }

                $view = new UpdatesView($smarty);
                $model = new UpdatesModel($view);
                $controller = new UpdatesController($model);

                try {
                    $controller->fetchUpdates();
                } catch (Exception $e) {
                    $exception = $e;
                }
                break;

            case 'register':
                $view = new RegisterView($smarty);
                $model = new RegisterModel($view);
                $controller = new RegisterController($model);

                try {
                    $controller->checkValidRegistration();
                    $username = $model->getUsername();

                    if ($model->isRegistered()) {
                        $view = new RegisteredView($smarty);
                        $model = new RegisteredModel($view);
                        $model->setUsername($username);
                    }
                } catch (Exception $e) {
                    $exception = $e;
                }
                break;

            case 'login':
                $view = new LoginView($smarty);
                $model = new LoginModel($view);
                $controller = new LoginController($model);

                try {
                    $controller->checkValidLogin();

                    if ($model->isLoggedIn()) { // successful login
                        $view = new LoggedInView($smarty);
                        $model = new LoggedInModel($view);
                        $model->setUsername($_SESSION['username']);
                    }
                } catch (Exception $e) {
                    $exception = $e;
                }
                break;

            case 'logout':
                $view = new LogoutView($smarty);
                $model = new LogoutModel($view, $this->isLoggedIn());
                $controller = new LogoutController($model);

                try {
                    $controller->logout();
                } catch (Exception $e) {
                    $exception = $e;
                }
                break;

            case 'debug':
                if (!$this->isLoggedIn() || $_SESSION['rank'] != 'ADMIN') {
                    $exception = new Exception('You must be <a href="?action=login">logged in<a> to an administrator\'s account view the debug page.');
                    break;
                }

                $view = new DebugView($smarty);
                break;

            /* any unhandled action return them to the welcome screen */
            default:
                $this->path = 'index';
                $view = new IndexView($smarty);
                break;
        }

        if ($exception !== null) {
            $view = new ErrorView($smarty);
            $model = new ErrorModel($view);
            $model->setMessage($exception->getMessage());
        }


        if (!DEBUG_MODE) {
            /* optimize the output by removing whitespace */
            $smarty->loadFilter("output", "trimwhitespace");
        }

        /* apply view specific information to the template engine */
        $view->applyTemplate($this->isLoggedIn());

        /* display generated template */
        $smarty->display($view->getId() . '.tpl');
    }

}
