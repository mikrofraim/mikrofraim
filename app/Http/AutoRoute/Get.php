<?php

declare(strict_types=1);

namespace App\Http\AutoRoute;

use App\Http\Controller\Controller;
use Nyholm\Psr7\Response;

class Get extends Controller
{
    public function handle()
    {
        if (file_exists('../VERSION')) {
            $version = trim((string) file_get_contents('../VERSION'));
        } else {
            $version = 'unknown';
        }

        $response = new Response();

        $response->getBody()->write(
            $this->twig->render('view/welcome.html', [
                'version' => $version,
            ]),
        );

        return $response;
    }
}
