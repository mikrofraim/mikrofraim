<?php

declare(strict_types=1);

namespace App\Http\Controller;

use Nyholm\Psr7\Response;

class Example extends Controller
{
    public function getExample()
    {
        if (\file_exists('../VERSION')) {
            $version = \trim(\file_get_contents('../VERSION'));
        } else {
            $version = 'unknown';
        }

        $response = new Response();

        $response->getBody()->write(
            $this->twig->render('welcome.html', [
                'version' => $version,
            ]),
        );

        return $response;
    }

    public function postExample()
    {
        return new Response(302, ['Location' => '/']);
    }
}
