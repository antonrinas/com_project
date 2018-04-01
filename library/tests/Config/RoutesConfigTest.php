<?php

use PHPUnit\Framework\TestCase;
use Framework\Config\RoutesConfig;

class RoutesConfigTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- FRAMEWORK: RoutesConfig tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $config = new RoutesConfig();
        $this->assertInstanceOf(
            RoutesConfig::class,
            $config
        );
    }

    /**
     * @expectedException \Framework\Config\ApplicationConfigException
     */
    public function testException()
    {
        echo PHP_EOL . "    ---- Can throw exception with invalid data" . PHP_EOL;

        $config = 'test';

        new RoutesConfig($config);
    }
}