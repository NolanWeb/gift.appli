<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\box\BoxesServiceNotFoundException;
use gift\appli\core\services\box\BoxService;
use gift\appli\core\services\box\BoxServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ViewBoxAction
{
    private BoxServiceInterface $boxService;

    public function __construct()
    {
        $this->boxService = new BoxService();
    }

    /**
     * @throws SyntaxError
     * @throws BoxesServiceNotFoundException
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $boxId = $_SESSION['last_box_id'] ?? null;
        if (!$boxId) {
            $boxContents = [];
        } else {
            $boxContents = $this->boxService->getBoxContents($boxId);
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'ViewBoxVue.html.twig', [
            'boxContents' => $boxContents,
            'path' => $request->getUri()->getPath()
        ]);
    }
}
