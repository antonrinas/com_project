<?php

return [
    'routes' => [
        [
            'url' => '/',
            'request_method' => 'GET',
            'module' => 'Main',
            'namespace' => 'Controller',
            'controller' => 'Index',
            'method' => 'index',
        ],
        /**
         * API
         */
        // Comments
        [
            'url' => '/api/comments',
            'request_method' => 'GET',
            'module' => 'Api',
            'namespace' => 'Controller',
            'controller' => 'Comment',
            'method' => 'index',
        ],
        [
            'url' => '/api/comments',
            'request_method' => 'POST',
            'module' => 'Api',
            'namespace' => 'Controller',
            'controller' => 'Comment',
            'method' => 'store',
        ],
    ],
];