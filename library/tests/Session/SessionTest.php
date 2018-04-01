<?php

use PHPUnit\Framework\TestCase;
use Framework\Session\Session;
use Framework\Session\SessionInterface;

class SessionTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- FRAMEWORK: Session tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $session = new Session();
        $this->assertInstanceOf(
            Session::class,
            $session
        );

        return $session;
    }

    /**
     * @param SessionInterface $session
     * @depends clone testCanBeCreated
     */
    public function testCanSetGetData($session)
    {
        echo PHP_EOL . "    ---- Can set/get data test" . PHP_EOL;
        $session->set('param', 'value');
        $this->assertTrue($session->isExists('param'));
        $this->assertSame('value', $session->get('param'));
        $session->setUserData('userData');
        $this->assertSame('userData', $session->getUserData());
        $session->clear();
        $this->assertFalse($session->getUserData());
        $this->assertSame('default', $session->get('param', 'default'));
    }
}