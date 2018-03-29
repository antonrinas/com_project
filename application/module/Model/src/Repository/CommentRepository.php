<?php

namespace Model\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Model\Entity\Comment;
use Doctrine\ORM\AbstractQuery;

class CommentRepository implements CommentRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * CommentRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
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

    /**
     * @return mixed
     *
     * @throws \Doctrine\ORM\NoResultException
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countAll()
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('count(comments.id)')
                     ->from(Comment::class, 'comments');

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * @param $results
     *
     * @return array
     */
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