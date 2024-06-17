<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\auth\AuthService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use gift\appli\core\services\auth\SessionManager;
use Slim\Views\Twig;

class UserController
{
    public function __construct()
    {
    }

    public function __invoke(Request $request, Response $response, $args): Response
    {
        if ($request->getMethod() === 'GET') {
            return $this->showSigninForm($request, $response);
        } else {
            return $this->signin($request, $response);
        }
    }

    public function showSigninForm(Request $request, Response $response): Response
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'signin.html.twig');
    }

    public function signin(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $email = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        $authService = new AuthService();
        $user = $authService->authenticate($email, $password);

        if ($user) {
            $sessionManager = new SessionManager();
            $sessionManager->login($user);
            return $response->withHeader('Location', '/categories')->withStatus(302);
        } else {
            return $response->withHeader('Location', '/signin')->withStatus(302);
        }
    }
}