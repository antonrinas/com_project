<?php

use PHPUnit\Framework\TestCase;
use Framework\Mvc\Controller\FrontController;
use Framework\Mvc\Controller\Response\ResponseInterface;
use Framework\Mvc\Controller\Dispatcher\DispatcherInterface;

class FrontControllerTest extends TestCase
{
    public function testCanHandleRequest()
    {
        echo PHP_EOL . " -- FRAMEWORK: FrontController tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can handle request test" . PHP_EOL;
        $frontController = new FrontController(new TestDispatcher());
        $this->assertInstanceOf(
            FrontControllerTestResponse::class,
            $frontController->handleRequest()
        );
    }
}

class TestDispatcher implements DispatcherInterface
{
    public function dispatch()
    {
        return new FrontControllerTestResponse();
    }
}

class FrontControllerTestResponse implements ResponseInterface
{
    public function getHeaders(){}
    public function setHeaders($headers){}
    public function setHeader($name, $value){}
    public function getCookies(){}
    public function setCookies($cookies){}
    public function setCookie($name, $value, $expire, $path, $domain, $secure, $httponly){}
    public function getContent(){}
    public function setContent($content){}
    public function getStatusCode(){}
    public function setStatusCode($statusCode){}
    public function __toString(){}
}