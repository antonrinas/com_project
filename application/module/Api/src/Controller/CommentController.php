<?php

namespace Api\Controller;

use Api\Core\Constants;
use Api\Service\CommentServiceInterface;
use Main\Validator\BaseValidatorInterface;

class CommentController extends BaseApiController
{
    /**
     * @var CommentServiceInterface
     */
    private $commentService;

    /**
     * @var BaseValidatorInterface
     */
    private $validator;

    /**
     * CommentController constructor.
     * @param CommentServiceInterface $commentService
     * @param BaseValidatorInterface $validator
     */
    public function __construct(CommentServiceInterface $commentService, BaseValidatorInterface $validator)
    {
        $this->commentService = $commentService;
        $this->validator = $validator;
    }

    /**
     * Retrieve comments list
     *
     * @return string
     */
    public function index()
    {
        try {
            return $this->getView()
                        ->setParams(
                            $this->commentService
                                 ->retrieveList((int) $this->getRequest()->getGetParam('page'))
                        )->render();
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
     * Add comment
     *
     * @return string
     */
    public function store()
    {
        try {
            $postParams = $this->getRequest()->getPostParams();
            $this->validator->setFormData($postParams);
            if (!$this->validator->isValid()){
                $this->getResponse()->setStatusCode(Constants::UNPROCESSABLE_ENTITY_STATUS_CODE);
                return $this->getView()->setParams([
                    'status' => Constants::WARNING_STATUS,
                    'messages' => $this->validator->getErrors(),
                ])->render();
            }
            $this->getEventManager()->fire(
                'onSubmit',
                ['formData' => $this->validator->getFormData()]
            );
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