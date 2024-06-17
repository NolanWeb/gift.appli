<?php

namespace gift\appli\core\services\catalogue;

use gift\appli\core\domain\entities\Categorie;
use gift\appli\core\domain\entities\Prestation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use mysql_xdevapi\Exception;

class CatalogueService implements CatalogueServiceInterface
{

    /**
     * @throws CatalogueServiceNotFoundException
     */
    public function getCategories(): array
    {
        try {
            $categories = Categorie::all();
        } catch (ModelNotFoundException $e) {
            throw new CatalogueServiceNotFoundException("Erreur lors de la récupération des catégories", 0, $e);
        }
        return $categories->toArray();
    }

    /**
     * @throws CatalogueServiceNotFoundException
     */
    public function getCategorieById(int $id): array
    {
        try {
            $categorieById = Categorie::with("prestations")->findOrFail($id);
        } catch (ModelNotFoundException $e){
            throw new CatalogueServiceNotFoundException("La catégorie {$id} n'existe pas", 0, $e);
        }
        return $categorieById->toArray();
    }

    /**
     * @throws CatalogueServiceNotFoundException
     */
    public function getPrestations($order = 'asc'): array
    {
        try {
            $prestations = Prestation::orderBy('tarif', $order)->get();
        } catch (ModelNotFoundException $e) {
            throw new Exception("Erreur lors de la récupération des prestations", 0, $e);
        }
        return $prestations->toArray();
    }

    /**
     * @throws CatalogueServiceNotFoundException
     */
    public function getPrestationById(string $id): array
    {
        try {

            $prestation = Prestation::find($id);

            if (!$prestation) throw new ModelNotFoundException();

            return $prestation->toArray();

        } catch (ModelNotFoundException $e) {
            throw new CatalogueServiceNotFoundException("La prestation {$id} n'existe pas", 0, $e);
        }

    }

    /**
     * @throws CatalogueServiceNotFoundException
     */
    public function getPrestationsbyCategorie(int $categ_id): array
    {
        try {
            $prestations = Categorie::findOrFail($categ_id)->prestations;
        } catch (ModelNotFoundException $e) {
            throw new CatalogueServiceNotFoundException("La catégorie {$categ_id} n'existe pas", $e);
        }
        return $prestations->toArray();
    }

    public function createCategory(array $categoryData): int
    {
        try {
            $category = new Categorie($categoryData);
            $category->save();
        } catch (ModelNotFoundException $e) {
            $category = null;
        }
        return $category->id;
    }

    public function modifyPrestation(array $prestationData): void
    {
        try {
            $prestation = Prestation::findOrFail($prestationData['id']);
            $prestation->fill($prestationData);
            $prestation->save();
        } catch (ModelNotFoundException $e) {
            $prestation = null;
        }
    }



    public function setPrestationCategory(int $prestationId, int $categoryId): void
    {
        try {
            $prestation = Prestation::findOrFail($prestationId);
            $prestation->categorie_id = $categoryId;
            $prestation->save();
        } catch (ModelNotFoundException $e) {
            $prestation = null;

        }
    }

    public function createPrestation(array $prestationData): int
    {
        try {
            $prestation = new Prestation();
            $prestation->id = \Ramsey\Uuid\Uuid::uuid4()->toString();
            $prestation->libelle = $prestationData['libelle'] ?? '';
            $prestation->description = $prestationData['description'];
            $prestation->unite = $prestationData['unite'] ?? null;
            $prestation->tarif = $prestationData['tarif'] ?? 0;
            $prestation->img = $prestationData['img'] ?? null;
            $prestation->cat_id = $prestationData['cat_id'];
            $prestation->save();
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la création de la prestation: " . $e->getMessage(), 0, $e);
        }
        return $prestation->id;
    }
}