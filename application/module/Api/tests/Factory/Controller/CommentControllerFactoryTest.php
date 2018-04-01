<?php

use PHPUnit\Framework\TestCase;
use Api\Factory\Controller\CommentControllerFactory;
use Framework\Instantiator\InstantiatorInterface;
use Api\Controller\CommentController;
use Framework\Instantiator\Instantiator;
use Framework\Instantiator\FactoryInterface;
use Framework\EventManager\EventManagerInterface;

class CommentControllerFactoryTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- API: CommentControllerFactory tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $factory = new CommentControllerFactory(new Instantiator());
        $this->assertInstanceOf(
            CommentControllerFactory::class,
            $factory
        );
    }

    public function testCanCreateController()
    {
        echo PHP_EOL . "    ---- Can create controller test" . PHP_EOL;

        $instantiator = new Instantiator();
        $factory = new CommentControllerFactory($instantiator);

        $controller = $factory($instantiator);
        $this->assertInstanceOf(
            CommentController::class,
            $controller
        );

        return $controller;
    }

    /**
     * @param ControllerInterface $controller
     * @depends clone testCanCreateController
     */
    public function testEventManagerExists($controller)
    {
        echo PHP_EOL . "    ---- Event manager exists test" . PHP_EOL;
        $this->assertInstanceOf(
            EventManagerInterface::class,
            $controller->getEventManager()
        );
    }

    /**
     * @param ControllerInterface $controller
     * @depends clone testCanCreateController
     */
    public function testInitialEventSubscription($controller)
    {
        echo PHP_EOL . "    ---- Initial event subscription done test" . PHP_EOL;
        $this->assertNotEmpty($controller->getEventManager()->getEventsMap());
    }
}