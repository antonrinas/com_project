<?php

use PHPUnit\Framework\TestCase;
use Model\Entity\Comment;
use Model\Entity\CommentInterface;

class CommentTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- MODEL: CommentEntity tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $entity = new Comment();
        $this->assertInstanceOf(
            Comment::class,
            $entity
        );

        return $entity;
    }

    /**
     * @param CommentInterface $entity
     * @depends clone testCanBeCreated
     */
    public function testCanSetGetValues($entity)
    {
        echo PHP_EOL . "    ---- Can set get values test" . PHP_EOL;
        $entity->setContent('content');
        $this->assertSame('content', $entity->getContent());
        $entity->setContentChanged('content changed');
        $this->assertSame('content changed', $entity->getContentChanged());
        $entity->setUserName('name');
        $this->assertSame('name', $entity->getUserName());
        $entity->setCreatedAt('created at');
        $this->assertSame('created at', $entity->getCreatedAt());
        $entity->setUpdatedAt('updated at');
        $this->assertSame('updated at', $entity->getUpdatedAt());

        echo  PHP_EOL . "#CommentEntity tests are completed#" . PHP_EOL;
    }
}