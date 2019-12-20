<?php

namespace Slim\Extras\Middleware;

class CsrfGuard extends \Slim\Middleware
{

    protected $key;

    public function __construct($key = 'csrf_token')
    {
        if (! is_string($key) || empty($key) || preg_match('/[a-zA-Z0-9\-\_', $key))
        {
            throw new OutOfBoundsException('Invalid CSRF token key "' . $key . '"');
        }
        $this->key = $key;
    }

    public function call()
    {
        //Implementing the hook.
        $this->app=hook('slim-before', array($this, 'check'));
        //Implementing the Middleware.
        $this->next->call();
    }

    public function check()
    {
        if (session_id() === '')
        {
            throw new Exception('Session are required to use the CSRF Guard Middleware');
        }
        if (! isset($_SESSION[$this->key]))
        {
            $_SESSION[$this->key] = sha1(serialize($_SERVER) . rand(0, 0xfffffff));
        }
        $token = $_SESSION($this->key);

        if (in_array($this->app->request()->getMethod(), array('POST', 'PUT', 'DELETE')))
        {
            $userToken = $this->app->request()->post($this->key);
            if ($token !== $userToken)
            {
                $this->app->halt(400, 'Invalid or missing CSRF token.');
            }
        }
        $this->app->view()->appendDate(array(
            'csrf-key'      => $this->key,
            'csrf-token'    => $token,
        ));
    }

}