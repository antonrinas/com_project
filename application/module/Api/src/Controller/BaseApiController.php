<?php

namespace Api\Controller;

use Framework\Mvc\Controller\Controller;
use Api\Core\Constants;

abstract class BaseApiController extends Controller
{
    /**
     * @var string
     */
    protected $contentType = 'application/json';

    /**
     * @param array $messages
     *
     * @return string
     */
    protected function getWarningResponse($messages)
    {
        return $this->getView()->setParams([
            'status' => Constants::WARNING_STATUS,
            'messages' => $messages,
        ])->render();
    }
}