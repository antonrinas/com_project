<?php

use PHPUnit\Framework\TestCase;
use Framework\ApplicationFactory;
use Framework\ApplicationInterface;

class ApplicationFactoryTest extends TestCase
{
    public function testCanInit()
    {
        echo PHP_EOL . " -- FRAMEWORK: ApplicationFactoryTest tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can init application test" . PHP_EOL;
        $applicationFactory = new ApplicationFactory();
        $application = $applicationFactory->init();
        $this->assertInstanceOf(
            ApplicationInterface::class,
            $application
        );
    }
}