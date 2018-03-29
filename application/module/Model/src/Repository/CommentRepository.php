<?php

namespace Model\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Model\Entity\Comment;
use Doctrine\ORM\AbstractQuery;

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
                     ->orderBy('comments.createdAt', 'DESC')
                     ->setFirstResult((int) $offset)
                     ->setMaxResults((int) $limit);
        $query = $queryBuilder->getQuery();
        $results = $query->getResult(AbstractQuery::HYDRATE_ARRAY);

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
            $createdAt = $item['createdAt'];
            $preparedResults[] = [
                'id' => $item['id'],
                'user_name' => urlencode($item['userName']),
                'content' => urlencode($item['content']),
                'created_at' => $createdAt->format('d.m.Y H:i:s'),
            ];
        }

        return $preparedResults;
    }
}