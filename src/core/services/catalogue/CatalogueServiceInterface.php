<?php

namespace gift\appli\core\services\catalogue;

interface CatalogueServiceInterface
{
    public function getCategories(): array;
    public function getCategorieById(int $id): array;
    public function getPrestations($order): array;
    public function getPrestationById(string $id): array;
    public function getPrestationsbyCategorie(int $categ_id):array;
}