<?php

use PHPUnit\Framework\TestCase;
use Api\Factory\Service\CommentServiceFactory;
use Api\Service\CommentService;
use Framework\Instantiator\Instantiator;

class CommentServiceFactoryTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- API: CommentServiceFactory tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $factory = new CommentServiceFactory(new Instantiator());
        $this->assertInstanceOf(
            CommentServiceFactory::class,
            $factory
        );
    }

    public function testCanCreateService()
    {
        echo PHP_EOL . "    ---- Can create service test" . PHP_EOL;

        $instantiator = new Instantiator();
        $factory = new CommentServiceFactory($instantiator);

        $service = $factory($instantiator);
        $this->assertInstanceOf(
            CommentService::class,
            $service
        );

        echo  PHP_EOL . "#CommentServiceFactory tests are completed#" . PHP_EOL;
    }
}