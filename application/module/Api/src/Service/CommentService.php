<?php

namespace Api\Service;

use Api\Core\Constants;
use DateTime;
use Model\Entity\CommentInterface;
use Model\Repository\CommentRepositoryInterface;
use Main\Service\PusherServiceInterface;

class CommentService implements CommentServiceInterface
{
    /**
     * @var CommentRepositoryInterface
     */
    private $commentRepository;

    /**
     * @var PusherServiceInterface
     */
    private $pusherService;

    /**
     * @var CommentInterface
     */
    private $comment;

    /**
     * CommentService constructor.
     * @param CommentRepositoryInterface $commentRepository
     * @param PusherServiceInterface $pusherService
     * @param CommentInterface $comment
     */
    public function __construct(
        CommentRepositoryInterface $commentRepository,
        PusherServiceInterface $pusherService,
        CommentInterface $comment
    )
    {
        $this->commentRepository = $commentRepository;
        $this->pusherService = $pusherService;
        $this->comment = $comment;
    }

    /**
     * @param int $page
     *
     * @return array
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function retrieveList($page)
    {
        $offset = Constants::ENTITIES_PER_PAGE * ($page - 1);
        $comments = $this->commentRepository->fetchAllForList(Constants::ENTITIES_PER_PAGE, $offset);

        return [
            'status' => Constants::OK_STATUS,
            'data' => $comments,
            'per_page' => Constants::ENTITIES_PER_PAGE,
            'total_rows' => $this->commentRepository->countAll()
        ];
    }

    /**
     * @param array $data
     */
    public function store($data)
    {
        $currentDateTime = new DateTime(date('Y-m-d H:i:s'));
        $this->comment->setUserName($data['user_name'])
                      ->setContent($data['content'])
                      ->setCreatedAt($currentDateTime)
                      ->setUpdatedAt($currentDateTime);
        $this->commentRepository->save($this->comment);
        $this->pushAddedMessage();
    }

    private function pushAddedMessage()
    {
        $this->pusherService->push('comments', 'added', [
            'id' => $this->comment->getId(),
            'user_name' => urlencode($this->comment->getUserName()),
            'content' => urlencode($this->comment->getContent()),
            'created_at' => $this->comment->getCreatedAt()->format('d.m.Y H:i:s')
        ]);
    }
}