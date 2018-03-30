<?php

use PHPUnit\Framework\TestCase;
use Framework\Instantiator\Instantiator;
use Framework\Instantiator\InstantiatorInterface;

class InstantiatorTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- FRAMEWORK: Instantiator tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $instantiator = new Instantiator();
        $this->assertInstanceOf(
            InstantiatorInterface::class,
            $instantiator
        );

        return $instantiator;
    }

    /**
     * @param InstantiatorInterface $instantiator
     * @depends clone testCanBeCreated
     */
    public function testCanFindFactory($instantiator)
    {
        echo PHP_EOL . "    ---- Can find factory test" . PHP_EOL;
        $instantiator->setFactoriesMap(['test' => TestFactory::class]);
        $this->assertSame(TestFactory::class, $instantiator->findFactory('test'));

        return $instantiator;
    }

    /**
     * @param InstantiatorInterface $instantiator
     * @depends clone testCanFindFactory
     * @expectedException TestFactoryException
     */
    public function testCanInstantiate($instantiator)
    {
        echo PHP_EOL . "    ---- Can instantiate test" . PHP_EOL;
        $instantiator->instantiate('test');
    }
}

class TestFactory
{
    public function __invoke()
    {
        throw new TestFactoryException('done');
    }
}

class TestFactoryException extends \Exception
{
}