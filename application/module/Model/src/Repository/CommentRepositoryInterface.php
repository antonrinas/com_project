<?php

namespace Model\Repository;

use Model\Entity\CommentInterface;

interface CommentRepositoryInterface
{
    /**
     * @param array|CommentInterface $entity
     */
    public function save($entity);

    /**
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public function fetchAllForList($limit, $offset);

    /**
     * @return mixed
     *
     * @throws \Doctrine\ORM\NoResultException
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countAll();
}