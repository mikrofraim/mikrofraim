<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Mikrofraim\ApplicationConfig;
use Mikrofraim\Service\Autowire\Autowire;
use Mikrofraim\ServiceContainer;
use Mikrofraim\ServiceProvider;

// set basePath and storagePath, used in configurations
$basePath = \dirname(__DIR__);
$storagePath = $basePath.'/storage';

// autoload
require $basePath.'/vendor/autoload.php';

// load environment file if one exists
if (\file_exists($basePath.'/.env')) {
    Dotenv::createImmutable($basePath)->load();
}

// read config
$config = require $basePath.'/config/config.php';

// create application config container
$applicationConfig = new ApplicationConfig($config['config']);

// set php ini settings
$applicationConfig->setPhpIniFromConfig($config['phpIni']);

// create service container, add the application config instance
$serviceContainer = new ServiceContainer();
$serviceContainer->set(ApplicationConfig::class, $applicationConfig);

// add all configured service providers to service container
foreach ($config['services'] as $serviceProviderClass) {
    /** @var ServiceProvider */
    $serviceProvider = new $serviceProviderClass($applicationConfig);
    $serviceContainer->addServiceProvider($serviceProvider);
}

/** @var \Mikrofraim\Service\Autowire\Autowire */
$autowire = $serviceContainer->get(Autowire::class);
$autowire->addContainer($serviceContainer);

$middlewareQueue = [];
foreach ($config['middleware'] as $middleware) {
    $middlewareQueue[] = $autowire->instantiateClass($middleware);
}

return $middlewareQueue;
