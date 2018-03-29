<?php

namespace Api\Service;


interface CommentServiceInterface
{
    public function retrieveList($page);

    public function store($data);
}