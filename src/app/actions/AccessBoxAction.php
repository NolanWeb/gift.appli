<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\box\BoxService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class AccessBoxAction
{
    private BoxService $boxService;
    private Twig $twig;

    public function __construct(Twig $twig)
    {
        $this->boxService = new BoxService();
        $this->twig = $twig;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $boxId = $args['id'];
        $box = $this->boxService->getBoxDetailsByAccessUrl($boxId);

        return $this->twig->render($response, 'AccessBoxVue.html.twig', [
            'box' => $box
        ]);
    }
}
