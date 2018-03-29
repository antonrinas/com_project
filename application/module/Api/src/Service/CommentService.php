<?php

namespace Api\Service;

use Api\Core\Constants;
use DateTime;
use Model\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Model\Repository\CommentRepositoryInterface;
use Main\Service\PusherServiceInterface;

class CommentService implements CommentServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var CommentRepositoryInterface
     */
    private $commentRepository;

    /**
     * @var PusherServiceInterface
     */
    private $pusherService;

    /**
     * CommentService constructor.
     * @param EntityManagerInterface $entityManager
     * @param CommentRepositoryInterface $commentRepository
     * @param PusherServiceInterface $pusherService
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        CommentRepositoryInterface $commentRepository,
        PusherServiceInterface $pusherService
    )
    {
        $this->entityManager = $entityManager;
        $this->commentRepository = $commentRepository;
        $this->pusherService = $pusherService;
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
        $comment = new Comment();
        $comment->setUserName($data['user_name'])
            ->setContent($data['content'])
            ->setCreatedAt($currentDateTime)
            ->setUpdatedAt($currentDateTime);
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
        $this->pushAddedMessage($comment);
    }

    /**
     * @param Comment $comment
     */
    private function pushAddedMessage(Comment $comment)
    {
        $this->pusherService->push('comments', 'added', [
            'id' => $comment->getId(),
            'user_name' => urlencode($comment->getUserName()),
            'content' => urlencode($comment->getContent()),
            'created_at' => $comment->getCreatedAt()->format('d.m.Y H:i:s')
        ]);
    }
}