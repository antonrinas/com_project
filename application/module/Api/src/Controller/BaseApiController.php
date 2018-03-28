<?php

namespace Api\Controller;

use Framework\Mvc\Controller\BaseController;
use Api\Core\Constants;
use Main\Exception\ControllerException;

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

    /**
     * @throws ControllerException
     */
    protected function authorizeAdmin()
    {
        $user = $this->getSession()->getUserData();
        $exception = new ControllerException('This resource is forbidden for your role');
        $exception->setCode(Constants::FORBIDEN_STATUS_CODE);
        if (!$user){
            throw $exception;
        }
        if ($user->getRoleId() != Constants::ADMIN_ROLE_ID){
            throw $exception;
        }
    }

    /**
     * @throws ControllerException
     */
    protected function authorizeUser()
    {
        $user = $this->getSession()->getUserData();
        $exception = new ControllerException('This resource is forbidden for your role');
        $exception->setCode(Constants::FORBIDEN_STATUS_CODE);
        if (!$user){
            throw $exception;
        }
        if ($user->getRoleId() != Constants::USER_ROLE_ID){
            throw $exception;
        }
    }

    protected function isAuthenticated()
    {
        $user = $this->getSession()->getUserData();
        $exception = new ControllerException('This resource is forbidden for your role');
        $exception->setCode(Constants::FORBIDEN_STATUS_CODE);
        if (!$user){
            throw $exception;
        }
    }

    /**
     * @param string $filePath
     */
    protected function unlinkFile($filePath)
    {
        if (is_file($filePath)){
            unlink($filePath);
        }
    }
}