<?php

use PHPUnit\Framework\TestCase;
use Framework\Config\ModulesConfig;

class ModulesConfigTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- FRAMEWORK: ModulesConfig tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $config = new ModulesConfig();
        $this->assertInstanceOf(
            ModulesConfig::class,
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

        new ModulesConfig($config);
    }
}