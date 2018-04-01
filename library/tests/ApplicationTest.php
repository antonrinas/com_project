<?php

use PHPUnit\Framework\TestCase;
use Framework\Application;
use Framework\Mvc\Controller\FrontControllerInterface;
use Framework\Config\ApplicationConfigInterface;
use Framework\Config\ApplicationConfigException;
use Framework\Config\ConfigInterface;

class ApplicationTest extends TestCase
{
    public function testCanStart()
    {
        echo PHP_EOL . " -- FRAMEWORK: Application tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can start test" . PHP_EOL;
        $application = new Application(TestApplicationConfig::getInstance(), new TestFrontController());
        $this->assertTrue($application->start());
    }
}

class TestApplicationConfig implements ApplicationConfigInterface
{
    public function __construct($directCall = true)
    {
        if ($directCall) {
            throw new ApplicationConfigException("Direct call is forbidden, use static method 'getInstance' instead");
        }

    }

    /**
     * @return TestApplicationConfig
     *
     * @throws ApplicationConfigException
     */
    public static function getInstance()
    {
        static $testApplicationConfig;
        if (!is_object($testApplicationConfig)) {
            $testApplicationConfig = new TestApplicationConfig(false);
        }

        return $testApplicationConfig;
    }

    public function getGlobalConfig()
    {
        return new TestGlobalConfig();
    }

    public function getDbConfig(){}

    public function getModulesConfig(){}

    public function getRoutesConfig(){}
}

class TestGlobalConfig implements ConfigInterface
{
    public function getConfig()
    {
        return [
            'development' => true,
            'date_default_timezone' => 'Europe/Kiev',
        ];
    }
}

class TestFrontController implements FrontControllerInterface
{
    public function handleRequest(){}
}