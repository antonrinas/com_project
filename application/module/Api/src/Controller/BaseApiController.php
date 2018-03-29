<?php

namespace Api\Controller;

use Framework\Mvc\Controller\Controller;
use Api\Core\Constants;

class BaseApiController extends Controller
{
    /**
     * @var string
     */
    protected $contentType = 'application/json';

    protected function getWarningResponse($messages)
    {
        return $this->getView()->setParams([
            'status' => Constants::WARNING_STATUS,
            'messages' => $messages,
        ])->render();
    }
}