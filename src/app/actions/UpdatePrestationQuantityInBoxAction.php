<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\box\BoxService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

class UpdatePrestationQuantityInBoxAction{
    private BoxService $boxService;

    public function __construct()
    {
        $this->boxService = new BoxService();
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $boxId = $args['box_id'];
        $prestationId = $args['prestation_id'];
        $quantity = $data['quantity'];

        $this->boxService->updatePrestationQuantityInBox($boxId, $prestationId, $quantity);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('details_box', ['id' => $boxId]);
        return $response->withStatus(302)->withHeader('Location', $url);
    }
}
