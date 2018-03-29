<?php

namespace Api\Controller;

use Api\Core\Constants;
use Api\Validator\Comment as CommentValidator;
use Api\Service\CommentServiceInterface;
use Api\Service\CommentService;
use Main\Validator\BaseValidatorInterface;

class CommentController extends BaseApiController
{
    /**
     * @var CommentServiceInterface
     */
    private $commentService;

    public function __construct()
    {
        parent::__construct();
        $this->commentService = new CommentService($this->entityManager);
    }

    /**
     * Retrieve tasks list
     *
     * @return string
     */
    public function index()
    {
        try {
            $page = (int) $this->getRequest()->getGetParam('page');

            return $this->getView()->setParams($this->commentService->retrieveList($page))->render();
        } catch(\Exception $e) {
            $this->getResponse()->setStatusCode($e->getCode());
            return $this->getView()->setParams([
                'status' => Constants::ERROR_STATUS,
                'message' => Constants::GENERAL_ERROR_MESSAGE,
                'message_for_developer' => $e->getMessage(),
            ])->render();
        }
    }

    /**
     * Add task
     *
     * @return string
     */
    public function store()
    {
        try {
            $postParams = $this->getRequest()->getPostParams();
            $validator = new CommentValidator($postParams);
            if (!$validator->isValid()){
                $this->getResponse()->setStatusCode(Constants::UNPROCESSABLE_ENTITY_STATUS_CODE);
                return $this->getView()->setParams([
                    'status' => Constants::WARNING_STATUS,
                    'messages' => $validator->getErrors(),
                ])->render();
            }
            $validData = $validator->getFormData();
            $this->commentService->store($validData);
            $this->getResponse()->setStatusCode(Constants::CREATED_STATUS_CODE);

            return $this->getView()->setParams(['status' => Constants::OK_STATUS,])->render();
        } catch(\Exception $e) {
            $this->getResponse()->setStatusCode($e->getCode());
            return $this->getView()->setParams([
                'status' => Constants::ERROR_STATUS,
                'message' => Constants::GENERAL_ERROR_MESSAGE,
                'message_for_developer' => $e->getMessage(),
            ])->render();
        }
    }
}