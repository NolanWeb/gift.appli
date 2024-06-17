<?php
namespace gift\appli\core\services\box;

use Exception;
use gift\appli\core\domain\entities\Box;
use gift\appli\core\domain\entities\Prestation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class BoxService implements BoxServiceInterface {
    public function createBox(array $boxData): string {
        try {
            $box = new Box();
            $box->id = $boxData['id'];
            $box->libelle = $boxData['libelle'];
            $box->description = $boxData['description'];
            $box->kdo = $boxData['kdo'] ?? null;
            $box->message_kdo = $boxData['message_kdo'] ?? null;
            $box->montant = 0;
            $box->token = bin2hex(random_bytes(32));
            $box->statut = Box::CREATED;
            $box->save();
        } catch (ModelNotFoundException $e) {
            $box = null;
        }
    return $box->id;
    }

    public function addPrestationToBox(string $boxId, string $prestationId, int $quantity): void
    {
        // Ajouter la prestation à la boxe dans la table `box2presta`
        DB::table('box2presta')->insert([
            'box_id' => $boxId,
            'presta_id' => $prestationId,
            'quantity' => $quantity
        ]);
    }

    /**
     * @throws BoxesServiceNotFoundException
     */
    public function getBoxContents(string $boxId): array
    {
        // Récupérer les prestations et leurs quantités pour une boxe spécifique
        $results = DB::table('box2presta')
            ->join('prestations', 'box2presta.presta_id', '=', 'prestations.id')
            ->where('box2presta.box_id', '=', $boxId)
            ->select('prestations.*', 'box2presta.quantity')
            ->get();

        $boxContents = [];
        foreach ($results as $result) {
            $boxContents[] = (object) [
                'prestation' => (object) [
                    'id' => $result->id,
                    'libelle' => $result->libelle,
                    'description' => $result->description,
                    'tarif' => $result->tarif,
                    'unite' => $result->unite
                ],
                'quantity' => $result->quantity
            ];
        }

        return $boxContents;
    }

    /**
     * @throws BoxesServiceNotFoundException
     */
    public function getBoxes(): array
    {
        try {
            $boxes = Box::all()->sortByDesc('updated_at');
            if (!$boxes) throw new ModelNotFoundException();
            return $boxes->toArray();
        } catch (ModelNotFoundException $e) {
            throw new BoxesServiceNotFoundException("Erreur interne", 500);
        }
    }

    public function getBoxById(string $id): array {
        try {
            $box = Box::with("prestations")->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new BoxesServiceNotFoundException("La box {$id} n'existe pas", 0, $e);
        }
        return $box->toArray();
    }

    public function getPrestationsByBox(string $id)
    {
        try {
            $res=[];
            $box = Box::find($id);
            $prestations = $box->prestation()->get();
            foreach($prestations as $p) array_push($res,$p->id);


            return $res;

        } catch (ModelNotFoundException $e) {
            throw new BoxesServiceNotFoundException("Erreur interne", 500);
        }
    }

}