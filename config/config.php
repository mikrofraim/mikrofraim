<?php

declare(strict_types=1);

use Mikrofraim\Application;

return [
    'config' => [
        'production' => Application::env('PRODUCTION', true),
        'app' => [
            'name' => 'example',
            'version' => 'dev',
        ],
        'basePath' => $basePath,
        'service' => [
            'twig' => [
                'templatesPath' => $basePath . '/resources/templates',
                'cachePath' => $storagePath . '/cache/twig',
                'cache' => false,
                'debug' => true,
            ],
            'monolog' => [
                'path' => $storagePath . '/logs/app.log',
                'format' => '%datetime% [%level_name%] %message%',
            ],
            'cache' => [
                'adapter' => 'filesystem',
                'adapters' => [
                    'filesystem' => [
                        'root' => $storagePath . '/cache',
                        'directory' => 'filecache',
                    ],
                    'redis' => [
                        'hostname' => Application::env('REDIS_HOSTNAME', '127.0.0.1'),
                        'port' => Application::env('REDIS_PORT', 6379),
                        'auth' => Application::env('REDIS_AUTH'),
                        'timeout' => 0,
                    ],
                ],
            ],
        ],
        'middleware' => [
            'session' => [
                'fallback_handler' => 'files',
                'fallback_path' => $storagePath . '/session',
            ],
        ],
    ],
    'services' => [
        \Mikrofraim\ServiceProvider\MiddlewarePipe::class,
        \Mikrofraim\ServiceProvider\RequestHandler::class,
        \Mikrofraim\ServiceProvider\Monolog::class,
        \Mikrofraim\ServiceProvider\SimpleCacheProvider::class,
        \Mikrofraim\ServiceProvider\TwigFilesystemLoader::class,
        \Mikrofraim\ServiceProvider\TwigEnvironment::class,
    ],
    'middleware' => [
        \App\Http\Middleware\Headers::class,
        \App\Http\Middleware\Favicon::class,
        \Mikrofraim\Http\Middleware\Session::class,
        \Mikrofraim\Http\Middleware\Router::class,
        \Mikrofraim\Http\Middleware\NotFound::class,
    ],
    'phpIni' => require 'phpIni.php',
    'phpIniAssert' => require 'phpIniAssert.php',
];
