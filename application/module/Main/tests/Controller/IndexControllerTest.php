<?php

use PHPUnit\Framework\TestCase;
use Main\Controller\IndexController;
use Framework\Mvc\View\ViewModelInterface;
use Framework\Mvc\Controller\ControllerInterface;

class IndexControllerTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- MAIN: IndexController tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $controller = new IndexController();
        $this->assertInstanceOf(
            IndexController::class,
            $controller
        );
        $controller->setView(new ViewModel());

        return $controller;
    }

    /**
     * @param ControllerInterface $controller
     * @depends clone testCanBeCreated
     */
    public function testCanShowIndexPage($controller)
    {
        echo PHP_EOL . "    ---- Can show index page test" . PHP_EOL;
        $this->assertSame(true, $controller->index());
    }
}

class ViewModel implements ViewModelInterface
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

    public function render()
    {
        return true;
    }
}