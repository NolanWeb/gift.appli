<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\box\BoxService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

class ValidateBoxAction
{
    private BoxService $boxService;

    public function __construct()
    {
        $this->boxService = new BoxService();
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $boxId = $args['id'];
        $this->boxService->validateBox($boxId);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('details_box', ['id' => $boxId]);
        return $response->withStatus(302)->withHeader('Location', $url);
    }
}
