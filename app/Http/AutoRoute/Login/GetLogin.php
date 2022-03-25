<?php

declare(strict_types=1);

namespace App\Http\AutoRoute\Login;

use App\Http\Controller\Controller;
use Nyholm\Psr7\Response;

class GetLogin extends Controller
{
    public function handle(string $action = null)
    {
        // render login
        $response = new Response();
        $response->getBody()->write(
            'login plogin!',
        );

        $this->logger->debug('lol');

        return $response;
    }
}
