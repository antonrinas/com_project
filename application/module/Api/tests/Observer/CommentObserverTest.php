<?php

use PHPUnit\Framework\TestCase;
use Api\Observer\CommentObserver;
use Framework\Instantiator\InstantiatorInterface;
use Api\Service\CommentServiceInterface;
use Framework\EventManager\ObserverInterface;

class CommentObserverTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- CommentObserver tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $observer = new CommentObserver(new Instantiator());
        $this->assertInstanceOf(
            CommentObserver::class,
            $observer
        );

        return $observer;
    }

    /**
     * @param ObserverInterface $observer
     * @depends clone testCanBeCreated
     */
    public function testOnSubmit($observer)
    {
        echo PHP_EOL . "    ---- On submit test" . PHP_EOL;

        $formData = [
            'user_name' => 'test user',
            'content' => 'test :-))) / ))) / :-)) / :)) / )) / :-| / :| / ((( / :-( / :(  /  :(( / (( / :-) / :) / ;-) / ;)',
        ];

        $this->assertSame(
            [
                'user_name' => 'test user',
                'content' => 'test :-))) / ))) / :-)) / :)) / )) / :-| / :| / ((( / :-( / :(  /  :(( / (( / :-) / :) / ;-) / ;)',
                'content_changed' => 'test <img src="/img/emoticons/happy.png" /> / <img src="/img/emoticons/happy.png" /> / <img src="/img/emoticons/happy.png" /> / <img src="/img/emoticons/happy.png" /> / <img src="/img/emoticons/happy.png" /> / <img src="/img/emoticons/confused.png" /> / <img src="/img/emoticons/confused.png" /> / <img src="/img/emoticons/sad.png" /> / <img src="/img/emoticons/sad.png" /> / <img src="/img/emoticons/sad.png" />  /  <img src="/img/emoticons/sad.png" />( / <img src="/img/emoticons/sad.png" /> / <img src="/img/emoticons/smiling.png" /> / <img src="/img/emoticons/smiling.png" /> / <img src="/img/emoticons/wink.png" /> / <img src="/img/emoticons/wink.png" />'
            ],
            $observer->onSubmit($formData)
        );
    }
}

class Instantiator implements InstantiatorInterface
{
    private $factoriesMap = [
        Api\Service\CommentServiceInterface::class => Api\Factory\Service\CommentServiceFactory::class,
    ];

    public function findFactory($className)
    {
        return $this->factoriesMap[Api\Service\CommentServiceInterface::class];
    }

    public function instantiate($className)
    {
        return new CommentServiceForObserver();
    }
}

class CommentServiceForObserver implements CommentServiceInterface
{
    public function retrieveList($page){}

    public function store($data){}
}