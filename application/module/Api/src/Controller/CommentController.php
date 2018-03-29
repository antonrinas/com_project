<?php

namespace Api\Controller;

use Main\Exception\ControllerException;
use Api\Core\Constants;
use DateTime;
use Model\Entity\Comment;
use Api\Validator\Comment as CommentValidator;
use Main\Service\PusherService;

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
            $validator = new CommentValidator($postParams);
            if (!$validator->isValid()){
                $this->getResponse()->setStatusCode(Constants::UNPROCESSABLE_ENTITY_STATUS_CODE);
                return $this->getView()->setParams([
                    'status' => Constants::WARNING_STATUS,
                    'messages' => $validator->getErrors(),
                ])->render();
            }
            $validData = $validator->getFormData();
            $currentDateTime = new DateTime(date('Y-m-d H:i:s'));
            $comment = new Comment();
            $comment->setUserName($validData['user_name'])
                    ->setContent($validData['content'])
                    ->setCreatedAt($currentDateTime)
                    ->setUpdatedAt($currentDateTime);
            $this->entityManager->persist($comment);
            $this->entityManager->flush();
            $this->pushAddedMessage($comment);
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

    private function pushAddedMessage($comment)
    {
        $pusherService = new PusherService();
        $pusherService->push('comments', 'added', [
            'id' => $comment->getId(),
            'user_name' => urlencode($comment->getUserName()),
            'content' => urlencode($comment->getContent()),
            'created_at' => $comment->getCreatedAt()->format('d.m.Y H:i:s')
        ]);
    }
}