<?php

use PHPUnit\Framework\TestCase;
use Model\Entity\Observer;
use Model\Entity\ObserverInterface;

class ObserverTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- MODEL: ObserverEntity tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $entity = new Observer();
        $this->assertInstanceOf(
            Observer::class,
            $entity
        );

        return $entity;
    }

    /**
     * @param ObserverInterface $entity
     * @depends clone testCanBeCreated
     */
    public function testCanSetGetValues($entity)
    {
        echo PHP_EOL . "    ---- Can set get values test" . PHP_EOL;
        $entity->setObserverClassName('observer_class_name');
        $this->assertSame('observer_class_name', $entity->getObserverClassName());
        $entity->setEventName('name');
        $this->assertSame('name', $entity->getEventName());
        $entity->setCreatedAt('created at');
        $this->assertSame('created at', $entity->getCreatedAt());
        $entity->setUpdatedAt('updated at');
        $this->assertSame('updated at', $entity->getUpdatedAt());

        echo  PHP_EOL . "#ObserverEntity tests are completed#" . PHP_EOL;
    }
}