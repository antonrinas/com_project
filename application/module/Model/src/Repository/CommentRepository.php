<?php

namespace Model\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Model\Entity\Comment;
//use Doctrine\ORM\AbstractQuery;

class CommentRepository
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function fetchAllForList($limit, $offset = 0)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select(array('comments'))
                     ->from(Comment::class, 'comments')
                     ->setFirstResult((int) $offset)
                     ->setMaxResults((int) $limit);
        $query = $queryBuilder->getQuery();
        $results = $query->getResult(/*AbstractQuery::HYDRATE_ARRAY*/);

        return $this->prepareResults($results);
    }

    public function countAll()
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('count(comments.id)')
                     ->from(Comment::class, 'comments');

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    private function prepareResults($results)
    {
        $preparedResults = [];
        foreach ($results as $item) {
            $preparedResults[] = [
                'id' => $item->getId(),
                'user_name' => urlencode($item->getUserName()),
                'content' => urlencode($item->getContent()),
                'created_at' => $item->getCreatedAt()->format('d.m.Y H:i:s'),
            ];
        }

        return $preparedResults;
    }
}