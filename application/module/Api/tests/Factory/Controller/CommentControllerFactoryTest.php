<?php

use PHPUnit\Framework\TestCase;
use Api\Factory\Controller\CommentControllerFactory;
use Framework\Instantiator\InstantiatorInterface;
use Api\Controller\CommentController;
use Framework\Instantiator\Instantiator;
use Framework\Instantiator\FactoryInterface;

class CommentControllerFactoryTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- CommentControllerFactory tests" . PHP_EOL;
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

        echo  PHP_EOL . "#CommentControllerFactory tests is completed#" . PHP_EOL;
    }
}