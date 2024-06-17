<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\catalogue\CatalogueService;
use gift\appli\core\services\catalogue\CatalogueServiceInterface;
use gift\appli\core\services\catalogue\CatalogueServiceNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

class ListePrestaAction
{
    private CatalogueServiceInterface $CatalogueService;

    public function __construct()
    {
        $this->CatalogueService = new CatalogueService();
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();
        $sortOrder = $queryParams['sort'] ?? 'asc';

        try {
            $prestations = $this->CatalogueService->getPrestations($sortOrder);
            $view = Twig::fromRequest($request);
            return $view->render(
                $response,
                'ListePrestaVue.html.twig',
                [
                    'prestations' => $prestations,
                    'sortOrder' => $sortOrder
                ]
            );
        } catch (CatalogueServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, "Erreur lors de la récupération des prestations");
        }
    }
}