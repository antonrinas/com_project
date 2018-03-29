<?php

namespace Api\Service;

use Api\Core\Constants;
use DateTime;
use Model\Entity\Comment;
use Main\Service\PusherService;
use Doctrine\ORM\EntityManagerInterface;

class CommentService implements CommentServiceInterface
{
    const ENTITIES_PER_PAGE = 5;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * CommentService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $page
     *
     * @return array
     */
    public function retrieveList($page)
    {
        $commentsRepository = new \Model\Repository\CommentRepository($this->entityManager);
        $offset = self::ENTITIES_PER_PAGE * ($page - 1);
        $comments = $commentsRepository->fetchAllForList(self::ENTITIES_PER_PAGE, $offset);

        return [
            'status' => Constants::OK_STATUS,
            'data' => $comments,
            'per_page' => self::ENTITIES_PER_PAGE,
            'total_rows' => $commentsRepository->countAll()
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
        $pusherService = new PusherService();
        $pusherService->push('comments', 'added', [
            'id' => $comment->getId(),
            'user_name' => urlencode($comment->getUserName()),
            'content' => urlencode($comment->getContent()),
            'created_at' => $comment->getCreatedAt()->format('d.m.Y H:i:s')
        ]);
    }
}