<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\box\BoxService;
use gift\appli\core\services\box\BoxServiceInterface;
use gift\appli\utils\CsrfService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;

class CreateBoxAction
{
    private BoxServiceInterface $boxService;

    public function __construct()
    {
        $this->boxService = new BoxService();
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        // Vérifier le token CSRF
        $data = $request->getParsedBody();
        if (!CsrfService::check($data['csrf_token'])) {
            throw new HttpBadRequestException($request, 'Invalid CSRF token');
        }

        // Créer la boxe et générer un ID unique
        $data['id'] = uniqid();
        $this->boxService->createBox($data);

        // Stocker l'ID de la box dans la session
        $_SESSION['last_box_id'] = $data['id'];

        // Rediriger vers la liste des catégories
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('categories');
        return $response->withStatus(302)->withHeader('Location', $url);
    }
}