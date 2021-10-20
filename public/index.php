<?php

declare(strict_types=1);

/* bootstrap the application */
$app = require '../bootstrap/bootstrap.php';

/* run the pipeline */
$app->get('requestHandler')->run();
