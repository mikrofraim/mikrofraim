<?php

declare(strict_types=1);

namespace App\Http\Controller;

use Mikrofraim\Http\Controller as BaseController;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment as TwigEnvironment;

class Controller extends BaseController
{
    public function __construct(
        protected ServerRequestInterface $request,
        protected TwigEnvironment $twig,
    ) {
    }
}
