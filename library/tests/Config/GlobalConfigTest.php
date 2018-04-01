<?php

use PHPUnit\Framework\TestCase;
use Framework\Config\GlobalConfig;

class GlobalConfigTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- FRAMEWORK: GlobalConfig tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $config = new GlobalConfig();
        $this->assertInstanceOf(
            GlobalConfig::class,
            $config
        );
    }

    /**
     * @expectedException \Framework\Config\ApplicationConfigException
     */
    public function testExceptionDevelopment()
    {
        echo PHP_EOL . "    ---- Can throw exception with invalid data" . PHP_EOL;

        $config = [
            'fail' => true,
            'date_default_timezone' => 'Europe/Kiev',
        ];

        new GlobalConfig($config);
    }

    /**
     * @expectedException \Framework\Config\ApplicationConfigException
     */
    public function testExceptionTimeZone()
    {
        echo PHP_EOL . "    ---- Can throw exception with invalid data" . PHP_EOL;

        $config = [
            'development' => true,
            'fail' => 'Europe/Kiev',
        ];

        new GlobalConfig($config);
    }
}