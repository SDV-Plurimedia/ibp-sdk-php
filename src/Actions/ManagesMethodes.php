<?php

namespace SdV\Ibp\Actions;

use SdV\Ibp\PaginatedResult;
use SdV\Ibp\Resources\Methode;

trait ManagesMethodes
{
    /**
     * Renvoie la liste des methodes.
     */
    public function methodes(array $query = []): PaginatedResult
    {
        $response = $this->get('methodes', $query);

        return new PaginatedResult(
            $this->mapToCollectionOf(Methode::class, $response['data']),
            $response['meta']
        );
    }

    /**
     * Renvoie une methode.
     */
    public function methode(string $methodeId): Methode
    {
        return new Methode($this->get("methodes/$methodeId")['data']);
    }

    /**
     * Création d'une méthode.
     */
    public function createMethode(array $payload): Methode
    {
        return new Methode($this->post('methodes', $payload)['data']);
    }

    /**
     * Met à jour une methode.
     */
    public function updateMethode(string $methodeId, array $payload): Methode
    {
        $response = $this->put("methodes/$methodeId", $payload);

        return new Methode($response['data']);
    }

    /**
     * Supprimer une methode.
     */
    public function deleteMethode(string $methodeId): bool
    {
        $this->delete("methodes/$methodeId");

        return true;
    }
}
