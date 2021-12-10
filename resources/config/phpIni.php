<?php

declare(strict_types=1);

return [
    'date.timezone' => 'UTC',
    'memory_limit' => '128M',
    'max_execution_time' => '30',
    'log_errors' => '1',
    'display_errors' => '0',
    'display_startup_errors' => '0',
    'session' => [
        'name' => 'session',
        'use_strict_mode' => '1',
        'sid_length' => '64',
        'gc_probability' => '0', /* @todo a way to expire sessions */
        'save_handler' => 'files',
        'save_path' => $storagePath . '/session',

        //
        // For Redis handler:
        //
        // 'save_handler' => 'redis',
        // 'save_path' => 'tcp://'
        //     . Application::env('REDIS_HOSTNAME', '127.0.0.1') . ':'
        //     . Application::env('REDIS_PORT', '6379') . '?auth='
        //     . Application::env('REDIS_AUTH'),
    ],
];
