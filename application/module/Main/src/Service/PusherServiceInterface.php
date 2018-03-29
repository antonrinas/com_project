<?php

namespace Main\Service;

interface PusherServiceInterface
{
    /**
     * @param array|string $channelNames
     * @param string $eventName
     * @param array $data
     *
     * @return void
     */
    public function push($channelNames, $eventName, $data);
}