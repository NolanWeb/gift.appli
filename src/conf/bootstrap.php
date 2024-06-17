<?php

declare(strict_types=1);

use gift\appli\utils\ConnectionBD;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

/* application boostrap */

$app = AppFactory::create();

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);

$app = (require_once __DIR__ . '/../conf/routes.php')($app);

ConnectionBD::init(__DIR__ . '/../conf/gift.db.conf.ini.dist');

$twig = Twig::create(
    __DIR__ . '/../app/views',
    [
        'cache' => false,
        'auto_reload' => true
    ]
);
$twig->getEnvironment()->addGlobal('css', 'assets/css');
$twig->getEnvironment()->addGlobal('images', 'assets/images');


$app->add(TwigMiddleware::create($app, $twig));

return $app;
