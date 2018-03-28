<?php

namespace Api\Controller;

use Main\Exception\ControllerException;
use Api\Core\Constants;

class CommentController extends BaseApiController
{
    const ENTITIES_PER_PAGE = 5;

    /**
     * Retrieve tasks list
     *
     * @return string
     */
    public function index()
    {
        try {
            $page = (int) $this->getRequest()->getGetParam('page');
            $commentsRepository = new \Model\Repository\CommentRepository($this->entityManager);
            $offset = self::ENTITIES_PER_PAGE * ($page - 1);
            $comments = $commentsRepository->fetchAllForList(self::ENTITIES_PER_PAGE, $offset);

            return $this->getView()->setParams(
                [
                    'status' => Constants::OK_STATUS,
                    'data' => $comments,
                    'per_page' => self::ENTITIES_PER_PAGE,
                    'total_rows' => $commentsRepository->countAll()
                ]
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
     * Add task
     *
     * @return string
     */
    public function store()
    {
        try {
            $postParams = $this->getRequest()->getPostParams();
            $validator = new TaskValidator($postParams);
            if (!$validator->isValid()){
                return $this->getView()->setParams([
                    'status' => Constants::WARNING_STATUS,
                    'messages' => $validator->getErrors(),
                ])->render();
            }



            $this->getResponse()->setStatusCode(201);
            $this->getResponse()->setHeader('Location', '/api/tasks/' . $id);

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