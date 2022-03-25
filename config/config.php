<?php

declare(strict_types=1);

use Mikrofraim\ApplicationConfig;

return [
    'config' => [
        'production' => ApplicationConfig::env('PRODUCTION', true),
        'app' => [
            'name' => 'example',
            'version' => 'dev',
        ],
        'basePath' => $basePath,
        'service' => [
            'twig' => [
                'templatesPath' => $basePath.'/resources/templates',
                'cachePath' => $storagePath.'/cache/twig',
                'cache' => false,
                'debug' => true,
            ],
            'monolog' => [
                'path' => $storagePath.'/logs/app.log',
                'format' => '%datetime% [%level_name%] %message%',
            ],
            'cache' => [
                'adapter' => 'filesystem',
                'adapters' => [
                    'filesystem' => [
                        'root' => $storagePath.'/cache',
                        'directory' => 'filecache',
                    ],
                    'redis' => [
                        'hostname' => ApplicationConfig::env('REDIS_HOSTNAME', '127.0.0.1'),
                        'port' => ApplicationConfig::env('REDIS_PORT', 6379),
                        'auth' => ApplicationConfig::env('REDIS_AUTH'),
                        'timeout' => 0,
                    ],
                ],
            ],
        ],
        'middleware' => [
            'session' => [
                'fallback_handler' => 'files',
                'fallback_path' => $storagePath.'/session',
            ],
        ],
        'routes' => require 'routes.php',
    ],
    'services' => [
        \Mikrofraim\ServiceProvider\AutowireProvider::class,
        \Mikrofraim\ServiceProvider\FastRouteRouterProvider::class,
        \Mikrofraim\ServiceProvider\Monolog::class,
        \Mikrofraim\ServiceProvider\SimpleCacheProvider::class,
        \Mikrofraim\ServiceProvider\TwigFilesystemLoader::class,
        \Mikrofraim\ServiceProvider\TwigEnvironment::class,
    ],
    'middleware' => [
        \App\Http\Middleware\Headers::class,
        \Mikrofraim\Http\Middleware\Session::class,
        \Mikrofraim\Http\Middleware\Router::class,
        \Mikrofraim\Http\Middleware\NotFound::class,
    ],
    'phpIni' => require 'phpIni.php',
];
