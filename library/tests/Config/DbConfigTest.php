<?php

use PHPUnit\Framework\TestCase;
use Framework\Config\DbConfig;

class DbConfigTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- FRAMEWORK: DbConfig tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $config = new DbConfig();
        $this->assertInstanceOf(
            DbConfig::class,
            $config
        );
    }

    /**
     * @expectedException \Framework\Config\ApplicationConfigException
     */
    public function testExceptionDb()
    {
        echo PHP_EOL . "    ---- Can throw exception with invalid data" . PHP_EOL;

        $config = [
            'db1' => [
                'default' => 'mysql',
                'mysql' => [
                    'bd_name' => 'com_project',
                    'bd_user' => 'admin',
                    'db_password' => 'admin',
                    'db_host' => 'localhost',
                ],
            ],
        ];

        new DbConfig($config);
    }

    /**
     * @expectedException \Framework\Config\ApplicationConfigException
     */
    public function testExceptionDefault()
    {
        echo PHP_EOL . "    ---- Can throw exception with invalid data" . PHP_EOL;

        $config = [
            'db' => [
                'default' => 'mysql1',
                'mysql' => [
                    'bd_name' => 'com_project',
                    'bd_user' => 'admin',
                    'db_password' => 'admin',
                    'db_host' => 'localhost',
                ],
            ],
        ];

        new DbConfig($config);
    }

    /**
     * @expectedException \Framework\Config\ApplicationConfigException
     */
    public function testExceptionDefault2()
    {
        echo PHP_EOL . "    ---- Can throw exception with invalid data" . PHP_EOL;

        $config = [
            'db' => [
                'default' => 'mysql',
                'mysql1' => [
                    'bd_name' => 'com_project',
                    'bd_user' => 'admin',
                    'db_password' => 'admin',
                    'db_host' => 'localhost',
                ],
            ],
        ];

        new DbConfig($config);
    }

    /**
     * @expectedException \Framework\Config\ApplicationConfigException
     */
    public function testException()
    {
        echo PHP_EOL . "    ---- Can throw exception with invalid data" . PHP_EOL;

        $config = [
            'db' => [
                'default' => 'mysql',
                'mysql' => [],
            ],
        ];

        new DbConfig($config);
    }
}