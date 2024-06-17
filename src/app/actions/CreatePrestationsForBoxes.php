<?php

namespace gift\appli\app\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

class CreatePrestationsForBoxes
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $parsedBody = $request->getParsedBody();
        $prestationId = $parsedBody['presta_id'];
        $quantity = (int)$parsedBody['quantity'];

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['box'])) {
            $_SESSION['box'] = [];
        }

        if (isset($_SESSION['box'][$prestationId])) {
            $_SESSION['box'][$prestationId] += $quantity;
        } else {
            $_SESSION['box'][$prestationId] = $quantity;
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('prestations');
        return $response->withHeader('Location', $url)->withStatus(302);
    }
}