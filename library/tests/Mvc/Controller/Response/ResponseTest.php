<?php

use PHPUnit\Framework\TestCase;
use Framework\Mvc\Controller\Response\Response;
use Framework\Mvc\Controller\Response\ResponseInterface;

class ResponseTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- FRAMEWORK: Response tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $response = new Response();
        $this->assertInstanceOf(
            Response::class,
            $response
        );

        return $response;
    }

    /**
     * @param ResponseInterface $response
     * @depends clone testCanBeCreated
     */
    public function testCanSetGetData($response)
    {
        echo PHP_EOL . "    ---- Can set/get data test" . PHP_EOL;
        $response->setCookies(['cookies' => 'cookies']);
        $this->assertSame(['cookies' => 'cookies'], $response->getCookies());
        $response->setCookies([]);
        $response->setCookie('name', 'value', 'expire', 'path', 'domain', 'secure', 'httponly');
        $this->assertSame(
            [[
                'name' => 'name',
                'value' => 'value',
                'expire' => 'expire',
                'path' => 'path',
                'domain' => 'domain',
                'secure' => 'secure',
                'httponly' => 'httponly'
            ]],
            $response->getCookies()
        );
        $response->setContent('content');
        $this->assertSame('content', $response->getContent());
        $response->setHeaders(['header' => 'header']);
        $this->assertSame(['header' => 'header'], $response->getHeaders());
        $response->setHeaders([]);
        $response->setHeader('name', 'value');
        $this->assertSame(
            [[
                'name' => 'name',
                'value' => 'value',
            ]],
            $response->getHeaders()
        );
    }
}