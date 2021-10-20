<?php

declare(strict_types=1);

namespace App\Http\Controller;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use Mikrofraim\Attribute\Route;
use Mikrofraim\Attribute\RouteMethod;

// #[Route('/')]
class Example extends Controller
{
    // #[RouteMethod('GET')]
    public function getExample()
    {
        if (\file_exists('../VERSION')) {
            $version = \file_get_contents('../VERSION');
        } else {
            $version = 'unknown';
        }

        $response = new Response();

        $response->getBody()->write(
            $this->twig->render('welcome.html', [
                'version' => $version,
                'request' => $this->request,
            ]),
        );

        return $response;
    }

    // #[RouteMethod('POST')]
    public function postExample()
    {
        return new RedirectResponse('/');
    }
}
