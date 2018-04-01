<?php

use PHPUnit\Framework\TestCase;
use Framework\Mvc\Controller\FrontControllerFactory;
use Framework\Mvc\Controller\FrontController;
use Framework\FactoryInterface;

class ControllerFactoryTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- FRAMEWORK: ControllerFactory tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $factory = new FrontControllerFactory();
        $this->assertInstanceOf(
            FrontControllerFactory::class,
            $factory
        );

        return $factory;
    }

    /**
     * @param FactoryInterface $factory
     * @depends clone testCanBeCreated
     */
    public function testCanInit($factory)
    {
        echo PHP_EOL . "    ---- Can init front controller test" . PHP_EOL;
        $frontController = $factory->init();
        $this->assertInstanceOf(
            FrontController::class,
            $frontController
        );
    }
}