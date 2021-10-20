<?php

declare(strict_types=1);

return [
    '/' => [
        'description' => 'default routing group',
        'middleware' => [], /* @todo implement */
        'routes' => [
            '/' => [
                'controller' => \App\Http\Controller\Example::class,
                'middleware' => [], /* @todo implement */
                'methods' => [
                    'get' => 'getExample',
                    'post' => 'postExample',
                ],
            ],
        ],
    ],
];
