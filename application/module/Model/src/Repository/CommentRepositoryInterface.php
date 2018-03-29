<?php

namespace Model\Repository;

interface CommentRepositoryInterface
{
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