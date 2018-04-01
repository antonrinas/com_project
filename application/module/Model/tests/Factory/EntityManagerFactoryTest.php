<?php

use PHPUnit\Framework\TestCase;
use Model\Factory\EntityManagerFactory;
use Api\Service\CommentService;
use Framework\Instantiator\Instantiator;
use Doctrine\ORM\EntityManager;

class EntityManagerFactoryTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- MODEL: EntityManagerFactory tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $factory = new EntityManagerFactory(new Instantiator());
        $this->assertInstanceOf(
            EntityManagerFactory::class,
            $factory
        );
    }

    public function testCanCreateManager()
    {
        echo PHP_EOL . "    ---- Can create manager test" . PHP_EOL;

        $instantiator = new Instantiator();
        $factory = new EntityManagerFactory($instantiator);

        $entityManager = $factory($instantiator);
        $this->assertInstanceOf(
            EntityManager::class,
            $entityManager
        );
    }
}