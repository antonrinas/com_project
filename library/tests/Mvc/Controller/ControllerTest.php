<?php

use PHPUnit\Framework\TestCase;
use Framework\Mvc\Controller\Controller;
use Framework\Mvc\Controller\ControllerInterface;

class ControllerTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- FRAMEWORK: Abstract controller tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $controller = new TestController();
        $this->assertInstanceOf(
            Controller::class,
            $controller
        );

        return $controller;
    }

    /**
     * @param ControllerInterface $controller
     * @depends clone testCanBeCreated
     */
    public function testCanSetGetData($controller)
    {
        echo PHP_EOL . "    ---- Can set/get data test" . PHP_EOL;
        $controller->setRequest('request');
        $this->assertSame('request', $controller->getRequest());
        $controller->setEventManager('eventManager');
        $this->assertSame('eventManager', $controller->getEventManager());
        $controller->setModuleConfig(['config']);
        $this->assertSame(['config'], $controller->getModuleConfig());
        $controller->setResponse('response');
        $this->assertSame('response', $controller->getResponse());
        $controller->setRoute('route');
        $this->assertSame('route', $controller->getRoute());
        $controller->setSession('session');
        $this->assertSame('session', $controller->getSession());
        $controller->setView('view');
        $this->assertSame('view', $controller->getView());
    }
}

class TestController extends Controller
{
}