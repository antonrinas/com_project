<?php

namespace Main\Service;

use Pusher\Pusher;

class PusherService implements PusherServiceInterface
{
    const AUTH_KEY = 'cdb14d8667c152df38cb';
    const SECRET = '6ab7fc3e2dc14d56431c';
    const APP_ID = '500230';

    /**
     * @var Pusher
     */
    private $pusher;

    public function __construct()
    {
        $options = [
            'cluster' => 'eu',
            'encrypted' => false
        ];
        $this->pusher = new Pusher(
            self::AUTH_KEY,
            self::SECRET,
            self::APP_ID,
            $options
        );
    }

    /**
     * @param array|string $channelNames
     * @param string $eventName
     * @param array $data
     *
     * @return void
     */
    public function push($channelNames, $eventName, $data)
    {
        $this->pusher->trigger($channelNames, $eventName, $data);
    }
}