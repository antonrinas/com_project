<?php

namespace Main\Service;

use Pusher\Pusher;

class PusherService implements PusherServiceInterface
{
    /**
     * @var Pusher
     */
    private $pusher;

    public function __construct()
    {
        $config = require (ROOT . DS . 'config' . DS . 'pusher.php');

        $options = [
            'cluster' => 'eu',
            'encrypted' => false
        ];
        $this->pusher = new Pusher(
            $config['auth_key'],
            $config['secret'],
            $config['app_id'],
            $config['options']
        );
    }

    /**
     * @param Pusher $pusher
     *
     * @return PusherService
     */
    public function setPusher($pusher)
    {
        $this->pusher = $pusher;
        return $this;
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
        return $this->pusher->trigger($channelNames, $eventName, $data);
    }
}