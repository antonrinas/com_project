<?php

use PHPUnit\Framework\TestCase;
use Framework\Mvc\Controller\Response\ResponseInterface;
use Framework\Mvc\Controller\Request\RequestInterface;
use Framework\Mvc\Controller\Router\RouterInterface;
use Framework\Mvc\Controller\Dispatcher\Dispatcher;
use Main\Controller\IndexController;
use Framework\Mvc\View\ViewModelInterface;

class DispatcherTest extends TestCase
{
    public function testCanDispatch()
    {
        echo PHP_EOL . " -- FRAMEWORK: Dispatcher tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can dispatch test" . PHP_EOL;

        $controller = new IndexController();
        $request = new TestRequest();
        $router = new TestRouter();
        $response = new TestResponse();
        $viewModel = new TestViewModel();
        $controller->setRequest($request)->setModuleConfig([])->setRoute($router->getMatchedRoute())->setView($viewModel);
        $dispatcher = new Dispatcher($request, $router, $response, $controller);

        $this->assertInstanceOf(
            ResponseInterface::class,
            $dispatcher->dispatch()
        );
    }
}

class TestRouter implements RouterInterface
{
    public function getGetParams(){}
    public function getParams(){}
    public function getMatchedRoute(){
        return [
            'url' => '/',
            'request_method' => 'GET',
            'module' => 'Main',
            'namespace' => 'Controller',
            'controller' => 'Index',
            'method' => 'index',
        ];
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

class TestRequest implements RequestInterface
{
    public function getRequestMethod(){}
    public function setRequestMethod($requestMethod){}
    public function getParams(){return [];}
    public function setParams($params){}
    public function getParam($name, $defaultValue){}
    public function getGetParams(){return [];}
    public function setGetParams($getParams){}
    public function getGetParam($name, $defaultValue){}
    public function getPostParams(){return [];}
    public function setPostParams($postParams){}
    public function getPostParam($name, $defaultValue){}
    public function getCookies(){}
    public function setCookies($cookies){}
    public function getCookie($name, $defaultValue){}
    public function getFiles(){}
    public function setFiles($files){}
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
    public function render(){return 'test';}
}