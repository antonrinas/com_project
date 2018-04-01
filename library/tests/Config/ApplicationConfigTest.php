<?php

use PHPUnit\Framework\TestCase;
use Framework\Config\ApplicationConfig;
use Framework\Config\ApplicationConfigInterface;
use Framework\Config\GlobalConfig;
use Framework\Config\DbConfig;
use Framework\Config\ModulesConfig;
use Framework\Config\RoutesConfig;

class ApplicationConfigTest extends TestCase
{
    /**
     * @expectedException Framework\Config\ApplicationConfigException
     */
    public function testCannotBeCreatedDirectly()
    {
        echo PHP_EOL . " -- FRAMEWORK: ApplicationConfig tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Cannot be created directly test" . PHP_EOL;

        new ApplicationConfig();
    }

    public function testSingleton()
    {
        echo PHP_EOL . "    ---- Can be created as singleton test" . PHP_EOL;

        $config = ApplicationConfig::getInstance();

        $this->assertInstanceOf(
            ApplicationConfig::class,
            $config
        );

        return $config;
    }

    /**
     * @param ApplicationConfigInterface $config
     * @depends testSingleton
     */
    public function testCanGetGlobalConfig($config)
    {
        echo PHP_EOL . "    ---- Can get global config test" . PHP_EOL;
        $this->assertInstanceOf(
            GlobalConfig::class,
            $config->getGlobalConfig()
        );
    }

    /**
     * @param ApplicationConfigInterface $config
     * @depends testSingleton
     */
    public function testCanGetDbConfig($config)
    {
        echo PHP_EOL . "    ---- Can get db config test" . PHP_EOL;
        $this->assertInstanceOf(
            DbConfig::class,
            $config->getDbConfig()
        );
    }

    /**
     * @param ApplicationConfigInterface $config
     * @depends testSingleton
     */
    public function testCanGetModulesConfig($config)
    {
        echo PHP_EOL . "    ---- Can get modules config test" . PHP_EOL;
        $this->assertInstanceOf(
            ModulesConfig::class,
            $config->getModulesConfig()
        );
    }

    /**
     * @param ApplicationConfigInterface $config
     * @depends testSingleton
     */
    public function testCanGetRoutesConfig($config)
    {
        echo PHP_EOL . "    ---- Can get modules routes test" . PHP_EOL;
        $this->assertInstanceOf(
            RoutesConfig::class,
            $config->getRoutesConfig()
        );
    }
}