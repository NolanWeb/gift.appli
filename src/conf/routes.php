<?php

declare(strict_types=1);

use gift\appli\app\actions\AddPrestationToBoxAction;
use gift\appli\app\actions\CheckLastBoxAction;
use gift\appli\app\actions\CreateBoxAction;
use gift\appli\app\actions\CreateBoxFormAction;
use gift\appli\app\actions\CreateCategAction;
use gift\appli\app\actions\CreateCategFormAction;
use gift\appli\app\actions\CreatePrestationsForBoxes;
use gift\appli\app\actions\CreatePrestationsFormAction;
use gift\appli\app\actions\DetailCategAction;
use gift\appli\app\actions\DetailBoxAction;
use gift\appli\app\actions\ListeBoxAction;
use gift\appli\app\actions\ListeCategAction;
use gift\appli\app\actions\DetailPrestationAction;
use gift\appli\app\actions\ListePrestaAction;
use gift\appli\app\actions\UserController;
use gift\appli\app\actions\ValidateBoxAction;
use gift\appli\app\actions\PayBoxAction;
use gift\appli\app\actions\RemovePrestationFromBoxAction;
use gift\appli\app\actions\UpdatePrestationQuantityInBoxAction;
use gift\appli\app\actions\GenerateBoxAccessUrlAction;
use gift\appli\app\actions\AccessBoxAction;
use gift\appli\app\actions\ViewBoxAction;
use Slim\App;

return function (App $app): \Slim\App {

    // Route pour afficher les catégories
    $app->get(
        '/categories',
        ListeCategAction::class
    )->setName('categories');

    // Route pour afficher les détails d'une catégorie
    $app->get(
        '/categorie/{id}',
        DetailCategAction::class
    )->setName('categorie');

    // Route pour afficher le formulaire de création d'une catégorie
    $app->get(
        '/categories/create',
        CreateCategFormAction::class
    )->setName('create_category_form');

    // Route pour créer une catégorie
    $app->post(
        '/categories/create',
        CreateCategAction::class
    )->setName('create_category');

    // Route pour lister les prestations
    $app->get('/prestations',
        ListePrestaAction::class
    )->setName('prestations');

    // Route pour afficher le détail d'une prestation
    $app->get('/prestation/{id}',
        DetailPrestationAction::class
    )->setName('prestation');

    // Route pour afficher les box
    $app->get('/boxes',
        ListeBoxAction::class
    )->setName('boxes');

    // Route pour afficher le formulaire de création d'une boxe
    $app->get('/boxes/create',
        CreateBoxFormAction::class
    )->setName('create_box_form');

    // Route pour créer une boxe
    $app->post('/boxes/create',
        CreateBoxAction::class
    )->setName('create_box');

    // Route pour ajouter une prestation à la boxe courante
    $app->post('/add-prestation',
        AddPrestationToBoxAction::class
    )->setName('add_prestation');

    // Route pour afficher le contenu de la boxe courante
    $app->get('/view-box',
        ViewBoxAction::class
    )->setName('view_box');

    // Route pour afficher le contenu d'une boxe spécifique
    $app->get('/boxes/{id}',
        ViewBoxAction::class
    )->setName('details_box');

    $app->post('/add-to-box',
        CreatePrestationsForBoxes::class
    )->setName('add_to_box');

    $app->get('/prestations/create',
        CreatePrestationsFormAction::class
    )->setName('create_form_prestation');

    $app->post('/prestations/create',
        CreatePrestationsFormAction::class
    )->setName('create_prestation');

    $app->get('/boxes/{id}/add-prestation',
        CreatePrestationsFormAction::class
    )->setName('create_prestations_for_boxes_form');

    $app->post('/boxes/{id}/add-prestation',
        CreatePrestationsForBoxes::class
    )->setName('create_prestations_for_boxes');

    $app->post('/boxes/{id}/validate',
        ValidateBoxAction::class
    )->setName('validate_box');

    $app->post('/boxes/{id}/pay',
        PayBoxAction::class
    )->setName('pay_box');

    $app->post('/boxes/{box_id}/remove-prestation/{prestation_id}',
        RemovePrestationFromBoxAction::class
    )->setName('remove_prestation_from_box');

    $app->post('/boxes/{box_id}/update-prestation/{prestation_id}',
        UpdatePrestationQuantityInBoxAction::class
    )->setName('update_prestation_quantity_in_box');

    $app->post('/boxes/{id}/generate-url',
        GenerateBoxAccessUrlAction::class
    )->setName('generate_box_access_url');

    $app->get('/boxes/access/{id}',
        AccessBoxAction::class
    )->setName('access_box');

    $app->map(['GET', 'POST'], '/signin', UserController::class)->setName('signin');

    $app->get('/register',
        UserController::class . ':registerForm'
    )->setName('registerform');

    $app->post('/register',
        UserController::class . ':register'
    )->setName('register');

    // Route pour vérifier l'ID de la dernière boxe
    $app->get('/check-last-box', CheckLastBoxAction::class)->setName('check_last_box');

    return $app;
};
