<?php

declare(strict_types=1);

return [
    '/' => [
        'description' => 'default routing group',
        'middleware' => [], // @todo implement
        'routes' => [
            '/' => [
                'controller' => \App\Http\AutoRoute\Get::class,
                'middleware' => [], // @todo implement
                'methods' => [
                    'get' => 'handle',
                    'post' => 'handle',
                ],
            ],
        ],
    ],
];
