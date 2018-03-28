<?php

namespace Framework\Mvc\Controller\Response;

class Response implements ResponseInterface
{
    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var array
     */
    private $cookies = [];

    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $statusCode = 200;

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     *
     * @return Response
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return Response
     */
    public function setHeader($name, $value)
    {
        $this->headers[] = ['name' => $name, 'value' => $value];
        return $this;
    }

    /**
     * @return array
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * @param array $cookies
     *
     * @return Response
     */
    public function setCookies($cookies)
    {
        $this->cookies = $cookies;
        return $this;
    }

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
    public function setCookie($name, $value = '', $expire = 0, $path = '', $domain = '', $secure = false, $httponly = false)
    {
        $this->cookies[] = [
            'name' => $name,
            'value' => $value,
            'expire' => $expire,
            'path' => $path,
            'domain' => $domain,
            'secure' => $secure,
            'httponly' => $httponly
        ];
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return Response
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     *
     * @return Response
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        foreach ($this->headers as $headerInfo)
        {
            header($headerInfo['name']. ': '. $headerInfo['value']);
        }
        foreach ($this->cookies as $cookieInfo)
        {
            setcookie(
                $cookieInfo['name'],
                $cookieInfo['value'],
                $cookieInfo['expire'],
                $cookieInfo['path'],
                $cookieInfo['domain'],
                $cookieInfo['secure'],
                $cookieInfo['httponly']
            );
        }
        header(':', true, $this->statusCode);

        echo $this->content;

        return '';
    }
}