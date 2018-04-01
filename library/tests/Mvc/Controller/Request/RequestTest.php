<?php

use PHPUnit\Framework\TestCase;
use Framework\Mvc\Controller\Request\Request;
use Framework\Mvc\Controller\Request\RequestInterface;

class RequestTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- FRAMEWORK: Request tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $request = new Request();
        $this->assertInstanceOf(
            Request::class,
            $request
        );

        return $request;
    }

    /**
     * @param RequestInterface $request
     * @depends clone testCanBeCreated
     */
    public function testCanSetGetData($request)
    {
        echo PHP_EOL . "    ---- Can set/get data test" . PHP_EOL;
        $request->setFiles(['files']);
        $this->assertSame(['files'], $request->getFiles());
        $request->setCookies(['cookies']);
        $this->assertSame(['cookies'], $request->getCookies());
        $request->setGetParams(['get']);
        $this->assertSame(['get'], $request->getGetParams());
        $request->setParams(['params']);
        $this->assertSame(['params'], $request->getParams());
        $request->setPostParams(['post']);
        $this->assertSame(['post'], $request->getPostParams());
        $request->setRequestMethod(['test']);
        $this->assertSame(['test'], $request->getRequestMethod());
        $request->setParams(['test' => 'params test']);
        $this->assertSame('params test', $request->getParam('test'));
        $this->assertSame('default', $request->getParam('test_default', 'default'));
        $request->setPostParams(['test' => 'params test']);
        $this->assertSame('params test', $request->getPostParam('test'));
        $this->assertSame('default', $request->getPostParam('test_default', 'default'));
        $request->setGetParams(['test' => 'params test']);
        $this->assertSame('params test', $request->getGetParam('test'));
        $this->assertSame('default', $request->getGetParam('test_default', 'default'));
    }
}