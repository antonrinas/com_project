<?php

use PHPUnit\Framework\TestCase;
use Model\Repository\CommentRepositoryInterface;
use Main\Service\PusherServiceInterface;
use Api\Service\CommentService;
use Api\Service\CommentServiceInterface;
use Model\Entity\Comment;
use Api\Core\Constants;

class CommentServiceTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- API: CommentService tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $commentRepository = new CommentRepository();
        $pusherService = new PusherService();
        $comment = new Comment();

        $service = new CommentService($commentRepository, $pusherService, $comment);
        $this->assertInstanceOf(
            CommentService::class,
            $service
        );

        return $service;
    }

    /**
     * @param CommentServiceInterface $service
     * @depends clone testCanBeCreated
     */
    public function testCanRetrieveList($service)
    {
        echo PHP_EOL . "    ---- Can retrieve list test" . PHP_EOL;
        $this->assertSame(
            [
                'status' => Constants::OK_STATUS,
                'data' => [
                    [
                        'id' => 1,
                        'user_name' => 'user 1',
                        'content' => 'comment 1',
                        'created_at' => 'datetime',
                    ]
                ],
                'per_page' => Constants::ENTITIES_PER_PAGE,
                'total_rows' => 1
            ],
            $service->retrieveList(1)
        );
    }

    /**
     * @param CommentServiceInterface $service
     * @depends clone testCanBeCreated
     */
    public function testCanStore($service)
    {
        echo PHP_EOL . "    ---- Can store test" . PHP_EOL;

        $this->assertTrue($service->store(
            [
                'user_name' => '',
                'content' => '',
                'content_changed' => ''
            ]
        ));
    }
}

class CommentRepository implements CommentRepositoryInterface
{
    public function save($entity)
    {
        return true;
    }

    public function fetchAllForList($limit, $offset = 0){
        return [
            [
                'id' => 1,
                'user_name' => 'user 1',
                'content' => 'comment 1',
                'created_at' => 'datetime',
            ],
        ];
    }

    public function countAll(){
        return 1;
    }
}

class PusherService implements PusherServiceInterface
{
    public function setPusher($pusher){}

    public function push($channelNames, $eventName, $data)
    {
        return true;
    }
}