<?php

namespace Framework\Mvc\Controller\Response;

interface ResponseInterface
{
    /**
     * @return array
     */
    public function getHeaders();

    /**
     * @param array $headers
     *
     * @return Response
     */
    public function setHeaders($headers);

    /**
     * @param string $name
     * @param string $value
     *
     * @return Response
     */
    public function setHeader($name, $value);

    /**
     * @return array
     */
    public function getCookies();

    /**
     * @param array $cookies
     *
     * @return Response
     */
    public function setCookies($cookies);

    /**
     * @param string $name
     * @param string $value
     * @param int $expire
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httponly
     *
     * @return Response
     */
    public function setCookie($name, $value, $expire, $path, $domain, $secure, $httponly);

    /**
     * @return string
     */
    public function getContent();

    /**
     * @param string $content
     *
     * @return Response
     */
    public function setContent($content);

    /**
     * @return int
     */
    public function getStatusCode();

    /**
     * @param int $statusCode
     *
     * @return Response
     */
    public function setStatusCode($statusCode);

    /**
     * @return string
     */
    public function __toString();
}