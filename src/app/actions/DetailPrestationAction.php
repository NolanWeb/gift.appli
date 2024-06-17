<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\catalogue\CatalogueService;
use gift\appli\core\services\catalogue\CatalogueServiceInterface;
use gift\appli\core\services\catalogue\CatalogueServiceNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

class DetailPrestationAction
{
    private CatalogueServiceInterface $catalogueService;

    public function __construct()
    {
        $this->catalogueService = new CatalogueService();
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        if (!isset($args['id'])) {
            throw new HttpNotFoundException($request, "ID de catégorie non fourni");
        }

        try {
            $prestation = $this->catalogueService->getPrestationById($args['id']);
            $view = Twig::fromRequest($request);
            return $view->render(
                $response,
                'DetailPrestationVue.html.twig',
                [
                    'prestation' => $prestation,
                ]
            );
        } catch (CatalogueServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, "Erreur lors de la récupération de la prestation");
        }
    }
}