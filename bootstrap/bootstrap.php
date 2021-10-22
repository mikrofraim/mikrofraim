<?php

declare(strict_types=1);

use Laminas\Diactoros\Response;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Laminas\Stratigility\MiddlewarePipe;
use Mikrofraim\ApplicationConfig;
use Mikrofraim\Http\ErrorResponseGenerator;
use Mikrofraim\Routes;
use Mikrofraim\Service\Autowire\Autowire;

/* set basePath and storagePath, used in configurations */
$basePath = \dirname(__DIR__);
$storagePath = $basePath . '/storage';

/* autoload */
require $basePath . '/vendor/autoload.php';

/* load environment file if one exists */
if (\file_exists($basePath . '/.env')) {
    $dotenv = \Dotenv\Dotenv::createImmutable($basePath);
    $dotenv->load();
}

/* read config */
$config = require $basePath . '/config/config.php';

/* set php ini configuration options */
$phpIniConfig = new ApplicationConfig($config['phpIni']);

foreach ($phpIniConfig->query('*') as $key => $value) {
    $phpIniConfig->setPhpIni($key, $value);
}

/* create application container and add config container */
$app = new \Mikrofraim\Application();
$app->set(ApplicationConfig::class, new ApplicationConfig($config['config']), 'config');

/* add autowire */
$app->set(Autowire::class, new Autowire(), 'autowire');

/* add routes */
$routes = new Routes();
$routes->set('routes', require $basePath . '/config/routes.php');
$app->set(Routes::class, $routes);

/* add all configured service providers to app container */
foreach ($config['services'] as $serviceProviderClass) {
    $app->addProvider(new $serviceProviderClass($app->get('config')));
}

/* get the autowire service, add the app container as a repository */
/** @var \Mikrofraim\Service\Autowire\Autowire */
$autowire = $app->get('autowire');

if (null !== $autowire) {
    $autowire->addContainer($app);
}

/* build the middleware pipeline */
/** @var MiddlewarePipe */
$pipeline = $app->get('middlewarePipe');

/* @todo @improve do we need this ? */
$pipeline->pipe(
    new ErrorHandler(
        static function () {
            return new Response();
        },
        new ErrorResponseGenerator(
            $config['config']['production'] ? false : true,
        ),
    ),
);

foreach ($config['middleware'] as $middleware) {
    $pipeline->pipe($autowire->instantiateClass($middleware));
}

/* return app instance */
return $app;
