<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\box\BoxService;
use gift\appli\core\services\box\BoxServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

class AddPrestationToBoxAction
{
    private BoxServiceInterface $boxService;

    public function __construct()
    {
        $this->boxService = new BoxService();
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $boxId = $_SESSION['last_box_id'] ?? null;
        if (!$boxId) {
            // Rediriger vers la création de boxe si aucune boxe n'est en cours
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $url = $routeParser->urlFor('create_box_form');
            return $response->withStatus(302)->withHeader('Location', $url);
        }

        $prestationId = $data['prestation_id'];
        $quantity = $data['quantity'];

        $this->boxService->addPrestationToBox($boxId, $prestationId, $quantity);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('view_box');
        return $response->withStatus(302)->withHeader('Location', $url);
    }
}