<?php

use PHPUnit\Framework\TestCase;
use Framework\Mvc\Controller\Dispatcher\DispatcherFactory;
use Framework\Mvc\Controller\Dispatcher\DispatcherInterface;
use Framework\FactoryInterface;

class DispatcherFactoryTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- FRAMEWORK: DispatcherFactory tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $dispatcherFactory = new DispatcherFactory();
        $this->assertInstanceOf(
            DispatcherFactory::class,
            $dispatcherFactory
        );

        return $dispatcherFactory;
    }

    /**
     * @param FactoryInterface $dispatcherFactory
     * @depends clone testCanBeCreated
     */
    public function testCanInit($dispatcherFactory)
    {
        echo PHP_EOL . "    ---- Can init dispatcher test" . PHP_EOL;
        $dispatcher = $dispatcherFactory->init();
        $this->assertInstanceOf(
            DispatcherInterface::class,
            $dispatcher
        );
    }
}