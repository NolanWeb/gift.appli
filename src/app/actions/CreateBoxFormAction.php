<?php

namespace gift\appli\app\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use gift\appli\utils\CsrfService;

class CreateBoxFormAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $token = CsrfService::generate();
        $view = Twig::fromRequest($request);
        return $view->render($response, 'CreateBoxFormVue.html.twig', ['csrf_token' => $token]);
    }
}
