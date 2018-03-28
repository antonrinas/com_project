<?php

namespace Framework\Mvc\Controller\Request;

interface RequestInterface
{
    /**
     * @return string
     */
    public function getRequestMethod();

    /**
     * @param string $requestMethod
     *
     * @return RequestInterface
     */
    public function setRequestMethod($requestMethod);

    /**
     * Get route match params
     *
     * @return array
     */
    public function getParams();

    /**
     * Set route match params
     *
     * @param array $params
     *
     * @return RequestInterface
     */
    public function setParams($params);

    /**
     * @param string $name
     * @param mixed $defaultValue
     *
     * @return mixed
     */
    public function getParam($name, $defaultValue);

    /**
     * Get $_GET params
     *
     * @return array
     */
    public function getGetParams();

    /**
     * Set $_GET params
     *
     * @param array $getParams
     *
     * @return RequestInterface
     */
    public function setGetParams($getParams);

    /**
     * @param string $name
     * @param mixed $defaultValue
     *
     * @return mixed
     */
    public function getGetParam($name, $defaultValue);

    /**
     * Get $_POST params
     *
     * @return array
     */
    public function getPostParams();

    /**
     * Set $_POST params
     *
     * @param array $postParams
     *
     * @return RequestInterface
     */
    public function setPostParams($postParams);

    /**
     * @param string $name
     * @param mixed $defaultValue
     *
     * @return mixed
     */
    public function getPostParam($name, $defaultValue);

    /**
     * @return array
     */
    public function getCookies();

    /**
     * @param array $cookies
     *
     * @return Request
     */
    public function setCookies($cookies);

    /**
     * @param string $name
     *
     * @param mixed $defaultValue
     *
     * @return mixed
     */
    public function getCookie($name, $defaultValue);

    /**
     * @return array
     */
    public function getFiles();

    /**
     * @param array $files
     *
     * @return Request
     */
    public function setFiles($files);
}