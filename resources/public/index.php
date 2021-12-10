<?php

declare(strict_types=1);

// bootstrap the application and get the middleware queue
$middlewareQueue = require '../bootstrap/bootstrap.php';

// create PSR-17 message factory
$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

// create PSR-7 ServerRequest
$serverRequest = (new \Nyholm\Psr7Server\ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
))->fromGlobals();

// create Relay instance
$relay = new \Relay\Relay($middlewareQueue);

// run middleware queue and get final response
$response = $relay->handle($serverRequest);

// emit response
(new \Mikrofraim\Http\SapiEmitter())->emit($response);
