<?php

use PHPUnit\Framework\TestCase;
use Main\Service\PusherService;
use Main\Service\PusherServiceInterface;

class PusherServiceTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- MAIN: PusherService tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $service = new PusherService();
        $this->assertInstanceOf(
            PusherService::class,
            $service
        );
        $service->setPusher(new Pusher());

        return $service;
    }

    /**
     * @param PusherServiceInterface $service
     * @depends clone testCanBeCreated
     */
    public function testCanPush($service)
    {
        echo PHP_EOL . "    ---- Can push test" . PHP_EOL;

        $this->assertSame(
            [
                'channel_names' => 'test',
                'event_name' => 'test_event',
                'data' => ['message' => 'test message'],
            ],
            $service->push('test', 'test_event', ['message' => 'test message'])
        );
    }
}

class Pusher
{
    public function trigger($channelNames, $eventName, $data)
    {
        return [
            'channel_names' => $channelNames,
            'event_name' => $eventName,
            'data' => $data,
        ];
    }
}