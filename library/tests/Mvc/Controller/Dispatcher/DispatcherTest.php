<?php

use PHPUnit\Framework\TestCase;
use Framework\Mvc\Controller\Response\ResponseInterface;
use Framework\Mvc\Controller\Request\RequestInterface;
use Framework\Mvc\View\ViewModelInterface;
use Framework\Mvc\View\JsonModelInterface;
use Framework\Session\SessionInterface;
use Framework\Instantiator\InstantiatorInterface;
use Framework\Mvc\Controller\Dispatcher\Dispatcher;
use Framework\Mvc\Controller\Dispatcher\DispatcherInterface;

class DispatcherTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- FRAMEWORK: Dispatcher tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;
        $dispatcher = new Dispatcher(
            new TestResponse(),
            new TestViewModel(),
            new TestJsonModel(),
            new TestSession(),
            new TestInstantiator()
        );
        $this->assertInstanceOf(
            DispatcherInterface::class,
            $dispatcher
        );

        return $dispatcher;
    }

    /**
     * @param DispatcherInterface $dispatcher
     * @depends clone testCanBeCreated
     */
    public function testCanSetGetConfig($dispatcher)
    {
        echo PHP_EOL . "    ---- Can set/get config test" . PHP_EOL;
        $config = [
            'url' => '/',
            'request_method' => 'GET',
            'module' => 'Main',
            'namespace' => 'Controller',
            'controller' => 'Index',
            'method' => 'index',
        ];
        $dispatcher->setConfig($config);
        $this->assertSame($config, $dispatcher->getConfig());
    }

    /**
     * @param DispatcherInterface $dispatcher
     * @depends clone testCanBeCreated
     */
    public function testCanSetGetRequest($dispatcher)
    {
        echo PHP_EOL . "    ---- Can set/get request test" . PHP_EOL;
        $dispatcher->setRequest(new TestRequest());
        $this->assertTrue($dispatcher->getRequest() instanceof RequestInterface);
    }
}

class TestResponse implements ResponseInterface
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

class TestViewModel implements ViewModelInterface
{
    public function getParams(){}
    public function setParams($params){}
    public function getLayoutName(){}
    public function setLayoutName($layoutName){}
    public function getModuleConfig(){}
    public function setModuleConfig($moduleConfig){}
    public function getControllerName(){}
    public function setControllerName($controllerName){}
    public function getMethodName(){}
    public function setMethodName($methodName){}
    public function getViewPath(){}
    public function setViewPath($viewPath){}
    public function setNoEscape($noEscape){}
    public function render(){}
}

class TestJsonModel implements JsonModelInterface
{
    public function getParams(){}
    public function setParams($params){}
    public function render(){}
}

class TestSession implements SessionInterface
{
    public function isExists($name){}
    public function get($name, $defaultValue = null){}
    public function set($name, $value){}
    public function setUserData($user){}
    public function getUserData(){}
    public function clear(){}
}

class TestInstantiator implements InstantiatorInterface
{


    public function setFactoriesMap($factoriesMap){}
    public function findFactory($className){}
    public function instantiate($className){}
}

class TestRequest implements RequestInterface
{
    public function getRequestMethod(){}
    public function setRequestMethod($requestMethod){}
    public function getParams(){}
    public function setParams($params){}
    public function getParam($name, $defaultValue){}
    public function getGetParams(){}
    public function setGetParams($getParams){}
    public function getGetParam($name, $defaultValue){}
    public function getPostParams(){}
    public function setPostParams($postParams){}
    public function getPostParam($name, $defaultValue){}
    public function getCookies(){}
    public function setCookies($cookies){}
    public function getCookie($name, $defaultValue){}
    public function getFiles(){}
    public function setFiles($files){}
}