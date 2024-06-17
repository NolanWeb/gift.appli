<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\catalogue\CatalogueService;
use gift\appli\core\services\catalogue\CatalogueServiceInterface;
use gift\appli\core\services\catalogue\CatalogueServiceNotFoundException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

class ListeCategAction
{
    private CatalogueServiceInterface $CatalogueService;

    public function __construct()
    {
        $this->CatalogueService = new CatalogueService();
    }

    public function __invoke($request, $response, $args)
    {
        try {
            $categories = $this->CatalogueService->getCategories();
            $view = Twig::fromRequest($request);
            return $view->render(
                $response,
                'ListeCategorieVue.html.twig',
                [
                    'categories' => $categories,
                ]
            );
        }
        catch (CatalogueServiceNotFoundException $e){
            throw new HttpNotFoundException($request, $response,"Erreur lors de la récupération des catégories");
        }

    }
}
