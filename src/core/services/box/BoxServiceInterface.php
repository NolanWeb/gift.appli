<?php
namespace gift\appli\core\services\box;

interface BoxServiceInterface
{
public function createBox(array $boxData): string;
public function getBoxes(): array;

public function getBoxContents(string $boxId): array;
public function addPrestationToBox(string $boxId, string $prestationId, int $quantity): void;
}