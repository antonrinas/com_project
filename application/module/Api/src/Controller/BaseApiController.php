<?php

namespace Api\Controller;

use Main\Controller\BaseController;
use Api\Core\Constants;

class BaseApiController extends BaseController
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