<?php

use PHPUnit\Framework\TestCase;
use Api\Controller\CommentController;
use Api\Service\CommentServiceInterface;
use Api\Validator\Comment as CommentValidator;
use Framework\Mvc\View\JsonModel;
use Framework\Mvc\Controller\Request\Request;
use Framework\Mvc\Controller\Response\Response;
use Api\Core\Constants;
use Framework\EventManager\EventManager;
use Framework\Mvc\Controller\ControllerInterface;

class CommentControllerTest extends TestCase
{
    public function testCanBeCreated()
    {
        echo PHP_EOL . " -- CommentController tests" . PHP_EOL;
        echo PHP_EOL . "    ---- Can be created test" . PHP_EOL;

        $commentService = new CommentService();
        $validator = new CommentValidator();
        $request = new Request();
        $response = new Response();
        $request->setGetParams(['page' => 1]);
        $eventManager = EventManager::getInstance();
        $controller = new CommentController($commentService, $validator);
        $controller->setView(new JsonModel())
                   ->setRequest($request)
                   ->setResponse($response)
                   ->setEventManager($eventManager);

        $this->assertInstanceOf(
            CommentController::class,
            $controller
        );

        return $controller;
    }

    /**
     * @param ControllerInterface $controller
     * @depends clone testCanBeCreated
     */
    public function testCanReturnList(ControllerInterface $controller)
    {
        echo  PHP_EOL . "    ---- Can return list test" . PHP_EOL;
        $this->assertSame(
            '{"status":"ok","data":[{"id":1,"content":"comment 1","user_name":"user 1","created_at":"datetime"}],"per_page":5,"total_rows":1}',
            $controller->index()
        );
    }

    /**
     * @param ControllerInterface $controller
     * @depends clone testCanBeCreated
     */
    public function testCanStore(ControllerInterface $controller)
    {
        echo  PHP_EOL . "    ---- Can store test" . PHP_EOL;
        $controller->getRequest()->setPostParams([
            'user_name' => 'test user',
            'content' => 'test content',
        ]);

        $this->assertSame(
            '{"status":"ok"}',
            $controller->store()
        );
    }

    /**
     * @param ControllerInterface $controller
     * @depends clone testCanBeCreated
     */
    public function testStoreValidationFails(ControllerInterface $controller)
    {
        echo  PHP_EOL . "    ---- Store validation fails test" . PHP_EOL;
        $controller->getRequest()->setPostParams([
            'user_name' => '',
            'content' => '',
        ]);
        $this->assertSame(1, strpos($controller->store(), '"status":"warning"'));

        echo  PHP_EOL . "#CommentController tests is completed#" . PHP_EOL;
    }
}

class CommentService implements CommentServiceInterface
{
    /**
     * @param int $page
     *
     * @return array
     */
    public function retrieveList($page)
    {
        return [
            'status' => Constants::OK_STATUS,
            'data' => [
                [
                    'id' => 1,
                    'content' => 'comment 1',
                    'user_name' => 'user 1',
                    'created_at' => 'datetime',
                ],
            ],
            'per_page' => 5,
            'total_rows' => 1
        ];
    }

    /**
     * @param array $data
     */
    public function store($data)
    {
    }
}