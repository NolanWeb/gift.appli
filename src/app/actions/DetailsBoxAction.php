<?php

namespace gift\appli\app\actions;

use Exception;
use gift\appli\core\services\box\BoxService;
use gift\appli\core\services\box\BoxServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

class DetailBoxAction
{
    private BoxServiceInterface $boxService;

    public function __construct()
    {
        $this->boxService = new BoxService();
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $boxId = $args['id'];

        // Mettre à jour l'ID de la boxe courante dans la session si nécessaire
        if (!isset($_SESSION['last_box_id']) || $_SESSION['last_box_id'] !== $boxId) {
            $_SESSION['last_box_id'] = $boxId;
        }

        // Récupérer les détails de la boxe
        try {
            $boxDetails = $this->boxService->getBoxContents($boxId);
        } catch (Exception $e) {
            throw new HttpNotFoundException($request, "Box not found");
        }

        // Afficher les détails de la boxe
        $view = Twig::fromRequest($request);
        return $view->render($response, 'DetailBoxVue.html.twig', ['boxDetails' => $boxDetails]);
    }
}