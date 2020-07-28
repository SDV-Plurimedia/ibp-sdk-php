<?php

namespace SdV\Ibp\Actions;

use SdV\Ibp\PaginatedResult;
use SdV\Ibp\Resources\Methode;

trait ManagesMethodes
{
    /**
     * Renvoie la liste des methodes.
     *
     * @return Methode[]
     */
    public function methodes(array $query = [])
    {
        $response = $this->get('methodes', $query);

        return new PaginatedResult(
            $this->mapToCollectionOf(Methode::class, $response['data']),
            $response['meta']
        );
    }

    /**
     * Renvoie une methode.
     *
     * @param  string $folderId
     * @return Folder
     */
    public function methode($methodeId)
    {
        return new Methode($this->get("methodes/$methodeId")['data']);
    }

    /**
     * Création d'un méthode.
     *
     * @param  array  $payload
     * @return Methode
     */
    public function createMethode(array $payload)
    {
        return new Methode($this->post('methodes', $payload)['data']);
    }

    /**
     * Met à jour une methode.
     *
     * @param  string $methodeId L'identifiant de la methode.
     * @param  array  $payload.
     * @return Methode
     */
    public function updateMethode($methodeId, array $payload)
    {
        $response = $this->put("methodes/$methodeId", $payload);

        return new Methode($response['data']);
    }

    /**
     * Supprimer une methode.
     *
     * @param  string $methodeId L'identifiant de la methode à supprimer.
     * @return boolean|Exception
     */
    public function deleteMethode($methodeId)
    {
        $this->delete("methodes/$methodeId");

        return true;
    }
}
