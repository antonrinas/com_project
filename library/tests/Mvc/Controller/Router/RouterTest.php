<?php

use PHPUnit\Framework\TestCase;
use Framework\Mvc\Controller\Router\RouterInterface;
use Framework\Mvc\Controller\Router\Router;
use Framework\Config\ConfigInterface;

class RouterTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- FRAMEWORK: Router tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;
        $router = new Router(new TestRoutesConfig());
        $this->assertInstanceOf(
            Router::class,
            $router
        );

        return $router;
    }

    /**
     * @param RouterInterface $router
     * @depends clone testCanBeCreated
     */
    public function testCanFindMatchedRoute($router)
    {
        echo PHP_EOL . "    ---- Can find matched route test" . PHP_EOL;
        $this->assertSame(
            [
                'url' => '/',
                'request_method' => 'GET',
                'module' => 'Main',
                'namespace' => 'Controller',
                'controller' => 'Index',
                'method' => 'index',
            ],
            $router->getMatchedRoute()
        );
    }

    /**
     * @expectedException \Framework\Mvc\Controller\Router\RouterException
     */
    public function testCanThrowException()
    {
        echo PHP_EOL . "    ---- Can throw exception test" . PHP_EOL;
        new Router(new TestWrongRoutesConfig());
    }
}

class TestRoutesConfig implements ConfigInterface
{
    private $config = [
        'routes' => [
            [
                'url' => '/',
                'request_method' => 'GET',
                'module' => 'Main',
                'namespace' => 'Controller',
                'controller' => 'Index',
                'method' => 'index',
            ],
        ],
    ];

    public function getConfig()
    {
        return $this->config;
    }
}

class TestWrongRoutesConfig implements ConfigInterface
{
    private $config = [
        'routes' => [
            [
                'url' => '/wrong-route',
                'request_method' => 'GET',
                'module' => 'Main',
                'namespace' => 'Controller',
                'controller' => 'Index',
                'method' => 'index',
            ],
        ],
    ];

    public function getConfig()
    {
        return $this->config;
    }
}