<?php

namespace Main\Service;

interface PusherServiceInterface
{
    /**
     * @param $pusher
     *
     * @return PusherServiceInterface
     */
    public function setPusher($pusher);

    /**
     * @param array|string $channelNames
     * @param string $eventName
     * @param array $data
     *
     * @return void
     */
    public function push($channelNames, $eventName, $data);
}