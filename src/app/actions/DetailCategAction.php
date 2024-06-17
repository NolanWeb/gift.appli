<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\catalogue\CatalogueServiceInterface;
use gift\appli\core\services\catalogue\CatalogueServiceNotFoundException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;
use gift\appli\core\services\catalogue\CatalogueService;

class DetailCategAction
{
    private CatalogueServiceInterface $catalogueService;

    public function __construct()
    {
        $this->catalogueService = new CatalogueService();
    }

    public function __invoke($request, $response, $args)
    {
        if (!isset($args['id'])) {
            throw new HttpNotFoundException($request, "ID de catégorie non fourni");
        }

        try {
            $categ = $this->catalogueService->getCategorieById($args['id']);
            $prestations = $this->catalogueService->getPrestationsbyCategorie($args['id']);
            $view = Twig::fromRequest($request);
            return $view->render(
                $response,
                'DetailCategorieVue.html.twig',
                [
                    'categ' => $categ,
                    'prestations' => $prestations
                ]
            );
        } catch (CatalogueServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, "Erreur lors de la récupération de la catégorie : " . $e->getMessage());
        }
    }
}
