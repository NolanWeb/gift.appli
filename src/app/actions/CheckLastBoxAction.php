<?php

namespace gift\appli\app\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class CheckLastBoxAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $lastBoxId = $_SESSION['last_box_id'] ?? 'Aucune boxe trouvée dans la session.';
        $view = Twig::fromRequest($request);
        return $view->render($response, 'CheckLastBoxVue.html.twig', ['lastBoxId' => $lastBoxId]);
    }
}