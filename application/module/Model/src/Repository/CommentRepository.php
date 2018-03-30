<?php

namespace Model\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Model\Entity\Comment;
use Doctrine\ORM\AbstractQuery;
use Model\Entity\CommentInterface;

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
     * @param array|CommentInterface $entity
     */
    public function save($entity)
    {
        if (is_array($entity)){
            foreach ($entity as $singleEntity){
                $this->entityManager->persist($singleEntity);
            }
        } else {
            $this->entityManager->persist($entity);
        }

        $this->entityManager->flush();
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
        $queryBuilder->select(['comments'])
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
                'user_name' => $item['userName'],
                'content' => $item['contentChanged'],
                'created_at' => $createdAt->format('d.m.Y H:i:s'),
            ];
        }

        return $preparedResults;
    }
}