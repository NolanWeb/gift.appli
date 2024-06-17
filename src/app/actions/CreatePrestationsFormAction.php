<?php

namespace gift\appli\app\actions;

use gift\appli\core\domain\entities\Prestation;
use gift\appli\core\services\catalogue\CatalogueService;
use gift\appli\core\services\catalogue\CatalogueServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
class CreatePrestationsFormAction
{
    private CatalogueServiceInterface $prestationService;

    public function __construct()
    {
        $this->prestationService = new CatalogueService();
    }

    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $parsedBody = $rq->getParsedBody();
        $name = htmlspecialchars($parsedBody['name'] ?? '');
        $description = htmlspecialchars($parsedBody['description'] ?? '');

        $this->prestationService->createPrestation([
            'name' => $name,
            'description' => $description
        ]);

        $routeParser = \Slim\Routing\RouteContext::fromRequest($rq)->getRouteParser();
        $url = $routeParser->urlFor('prestations');
        return $rs->withStatus(302)->withHeader('Location', $url);
    }
}
