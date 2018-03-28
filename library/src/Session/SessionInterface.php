<?php

namespace Framework\Session;

interface SessionInterface
{
    /**
     * @param string $name
     *
     * @return bool
     */
    public function isExists($name);

    /**
     * @param string $name
     * @param mixed $defaultValue
     *
     * @return mixed
     */
    public function get($name, $defaultValue = null);

    /**
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value);

    /**
     * @param mixed $user
     */
    public function setUserData($user);

    /**
     * @return mixed
     */
    public function getUserData();

    /**
     * @return void
     */
    public function clear();
}