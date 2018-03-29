<?php

return [
    'factories' => [
        Api\Controller\CommentController::class => Api\Factory\Controller\CommentControllerFactory::class,
        Api\Service\CommentServiceInterface::class => Api\Factory\Service\CommentServiceFactory::class,
    ]
];