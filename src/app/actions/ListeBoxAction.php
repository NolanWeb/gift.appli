<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\box\BoxesServiceNotFoundException;
use gift\appli\core\services\box\BoxService;
use gift\appli\core\services\box\BoxServiceInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

class ListeBoxAction
{
    private BoxServiceInterface $boxService;

    public function __construct()
    {
        $this->boxService = new BoxService();
    }

    public function __invoke($request, $response, $args)
    {
        try {
            $boxes = $this->boxService->getBoxes();
            $view = Twig::fromRequest($request);
            return $view->render(
                $response,
                'ListeBoxesVue.html.twig',
                [
                    'boxes' => $boxes,
                ]
            );
        } catch (BoxesServiceNotFoundException $e) {
            throw new HttpNotFoundException($request, $response, "Erreur lors de la récupération des boxes");
        }
    }
}