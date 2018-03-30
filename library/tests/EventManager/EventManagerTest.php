<?php

use PHPUnit\Framework\TestCase;
use Framework\EventManager\EventManager;
use Framework\EventManager\EventManagerInterface;
use Framework\EventManager\Observer;
use Framework\Instantiator\InstantiatorInterface;

class EventManagerTest extends TestCase
{
    /**
     * @expectedException \Framework\EventManager\EventManagerException
     */
    public function testCannotBeCreatedDirectly()
    {
        echo PHP_EOL . " -- FRAMEWORK: EventManager tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Cannot be created directly test" . PHP_EOL;

        new EventManager();
    }

    public function testSingleton()
    {
        echo PHP_EOL . "    ---- Can be created as singleton test" . PHP_EOL;

        $eventManager = EventManager::getInstance();

        $this->assertInstanceOf(
            EventManager::class,
            $eventManager
        );

        return $eventManager;
    }

    /**
     * @param EventManagerInterface $eventManager
     * @depends clone testSingleton
     */
    public function testCanGetSetEventsMap($eventManager)
    {
        echo PHP_EOL . "    ---- Can get/set eventsMap test" . PHP_EOL;

        $eventManager->setEventsMap(['test' => ['test']]);
        $this->assertSame(['test' => ['test']], $eventManager->getEventsMap());
    }

    /**
     * @param EventManagerInterface $eventManager
     * @depends clone testSingleton
     */
    public function testCanSubscribeObserver($eventManager)
    {
        echo PHP_EOL . "    ---- Can subscribe observer test" . PHP_EOL;
        $observer = new TestObserver(new Instantiator());
        $eventManager->subscribe('test', $observer);
        $eventManager->subscribe('testWithParams', $observer);
        $this->assertSame(
            [
                'test' => [$observer],
                'testWithParams' => [$observer],
            ],
            $eventManager->getEventsMap()
        );

        return $eventManager;
    }

    /**
     * @param EventManagerInterface $eventManager
     * @depends clone testCanSubscribeObserver
     * @expectedException TestObserverException
     */
    public function testCanFireEvents($eventManager)
    {
        echo PHP_EOL . "    ---- Can fire events test" . PHP_EOL;
        $eventManager->fire('test');
    }

    /**
     * @param EventManagerInterface $eventManager
     * @depends clone testCanSubscribeObserver
     * @expectedException TestObserverException
     */
    public function testCanFireEventsWithParams($eventManager)
    {
        echo PHP_EOL . "    ---- Can fire events with params test" . PHP_EOL;
        $eventManager->fire('testWithParams',
            ['param1' => 'param1', 'param2' => 'param2']
        );
    }
}

class TestObserver extends Observer
{
    private $observerWasUsed = false;

    public function test()
    {
        throw new TestObserverException('done');
    }

    public function testWithParams($param1, $param2)
    {
        if ($param1 === 'param1' && $param2 === 'param2') {
            throw new TestObserverException('done with params');
        }
    }
}

class TestObserverException extends \Exception
{
}

class Instantiator implements InstantiatorInterface
{
    public function setFactoriesMap($factoriesMap){}

    public function findFactory($className){}

    public function instantiate($className){}
}