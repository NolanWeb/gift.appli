<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use gift\appli\core\domain\entities\Box;
use gift\appli\core\domain\entities\Categorie;
use gift\appli\core\domain\entities\Prestation;
use Illuminate\Database\Capsule\Manager as DB;

$db = new DB();
$db->addConnection(parse_ini_file('../../conf/gift.db.conf.ini.dist'));
$db->setAsGlobal();
$db->bootEloquent();

// lister les prestations ; pour chaque prestation, afficher le libellé, la description, le
// tarif et l'unité.

$prestation = Prestation::all();

echo "\nQUESTION 1 : \n";

// foreach ($prestation as $p) {
//     echo '| libellé : ' . $p->libelle . ' - description : ' . $p->description . ' - tarif : ' . $p->tarif . ' - l\'unité : ' . $p->unite . "\n";
//     echo "---------------------------------------------------------------------------\n";
// }

// idem, mais en affichant de plus la catégorie de la prestation. On utilisera un
// chargement lié (eager loading).

echo "\nQUESTION 2 : \n";

$prestationn = Prestation::with('categorie')->get();

foreach ($prestationn as $p) {
    echo '| libellé : ' . $p->libelle . ' - description : ' . $p->description . ' - tarif : ' . $p->tarif . ' - l\'unité : ' . $p->unite . "\n";
    echo '| catégorie : ' . $p->categorie->libelle . "\n";
    echo "---------------------------------------------------------------------------\n";
}

// afficher la catégorie 3 (libellé) et la liste des prestations (libellé, tarif, unité) de cette
// catégorie. 

echo "\nQUESTION 3 : \n";

$categorie3 = Categorie::find(3);

echo 'Catégorie libelle : ' . $categorie3->libelle . "\n";

$prestaCateg3 = $categorie3->prestation;

foreach ($prestaCateg3 as $p) {
    echo 'libelle : ' . $p->libelle . ' - tarif : ' . $p->tarif . ' - l\'unité : ' . $p->unite . "\n";
}


// afficher la box d'ID 360bb4cc-e092-3f00-9eae-774053730cb2 : libellé, description,
// montant.

echo "\nQUESTION 4 : \n";

$boxIdDonner = Box::find('360bb4cc-e092-3f00-9eae-774053730cb2');

echo 'libelle : ' . $boxIdDonner->libelle . ' - la description : ' . $boxIdDonner->description . ' - le montant : ' . $boxIdDonner->montant . "\n";

// idem, en affichant en plus les prestations prévues dans la box (libellé, tarif, unité,
// quantité)

echo "\nQUESTION 5 : \n";

$boxIdDonner2 = Box::with('prestation')->find('360bb4cc-e092-3f00-9eae-774053730cb2');

echo 'libelle : ' . $boxIdDonner2->libelle . ' - la description : ' . $boxIdDonner2->description . ' - le montant : ' . $boxIdDonner2->montant . "\n";

$prestationBox = $boxIdDonner2->prestation;
foreach ($prestationBox as $p) {
    echo 'libelle : ' . $p->libelle . ' - tarif : ' . $p->tarif . ' - l\'unité : ' . $p->unite . "\n";
}
