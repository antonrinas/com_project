<?php

namespace Api\Service;


interface CommentServiceInterface
{
    /**
     * @param int $page
     *
     * @return array
     */
    public function retrieveList($page);

    /**
     * @param array $data
     */
    public function store($data);
}