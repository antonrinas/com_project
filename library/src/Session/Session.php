<?php

namespace Framework\Session;

class Session implements SessionInterface
{
    public function __construct()
    {
        if (!isset($_SESSION)){
            session_start();
        }
        if (!array_key_exists('application_session', $_SESSION)){
            $_SESSION['application_session'] = [];
        }
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function isExists($name)
    {
        return array_key_exists($name, $_SESSION['application_session']);
    }

    /**
     * @param string $name
     * @param mixed $defaultValue
     *
     * @return mixed
     */
    public function get($name, $defaultValue = null)
    {
        if (!array_key_exists($name, $_SESSION['application_session'])){
            return $defaultValue;
        }

        return $_SESSION['application_session'][$name];
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value)
    {
        $_SESSION['application_session'][$name] = $value;
    }

    /**
     * @param mixed $user
     */
    public function setUserData($user)
    {
        $_SESSION['application_session']['authenticated_user'] = $user;
    }

    /**
     * @return mixed
     */
    public function getUserData()
    {
        if (!array_key_exists('authenticated_user', $_SESSION['application_session'])){
            return false;
        }
        if (!($_SESSION['application_session']['authenticated_user'])){
            return false;
        }
        return $_SESSION['application_session']['authenticated_user'];
    }

    /**
     * @return void
     */
    public function clear()
    {
        $_SESSION['application_session'] = [];
    }
}