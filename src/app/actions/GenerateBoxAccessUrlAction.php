<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\box\BoxService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

class GenerateBoxAccessUrlAction
{
    private BoxService $boxService;

    public function __construct()
    {
        $this->boxService = new BoxService();
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $boxId = $args['id'];
        $url = $this->boxService->generateAccessUrl($boxId);

        return $response->withJson(['url' => $url], 200);
    }
}
