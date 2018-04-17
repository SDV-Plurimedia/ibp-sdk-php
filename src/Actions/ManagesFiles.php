<?php

namespace SdV\Ibp\Actions;

use SdV\Ibp\PaginatedResult;
use SdV\Ibp\Resources\File;

trait ManagesFiles
{
    /**
     * Renvoie la liste des files.
     *
     * @return File[]
     */
    public function files(array $query = [])
    {
        $response = $this->get('files', $query);

        return new PaginatedResult(
            $this->mapToCollectionOf(File::class, $response['data']),
            $response['meta']
        );
    }

    /**
     * Renvoie un file.
     *
     * @param  string $fileId
     * @return File
     */
    public function file($fileId)
    {
        return new File($this->get("files/$fileId")['data']);
    }

    /**
     * Tag un file à partir d'un service configuré sur IBP.
     *
     * @param  string $fileId  L'identifiant du file à tagger.
     * @param  string $service Le nom du service à utiliser.
     * @param  array|null $tags Les tags à ajouter au fichier (Utilisé uniquement par le service "manual")
     * @return File
     */
    public function tagFile($fileId, $service, $tags = null)
    {
        $payload = ['service' => $service];

        if ($service == 'manual') {
            $payload['tags'] = $tags;
        }

        return new File($this->post("files/$fileId/tags", $payload)['data']);
    }

    /**
     * Ajoute des données extras (externes) dans un file
     *
     * @param  string $fileId  L'identifiant du file.
     * @param  array $data Les données à ajouter ou mettre à jour
     * @return File
     */
    public function putExtras($fileId, $data)
    {
        $payload = [
            'extra' => $data,
        ];

        return new File($this->put("files/$fileId/extras", $payload)['data']);
    }

    /**
     * Ajoute ou met à jour une méthode sur un file.
     *
     * @param  string $fileId  L'id du file.
     * @param  array $payload
     * @return File
     */
    public function upsertMethodeOnFile($fileId, $payload)
    {
        return new File($this->put("files/$fileId/methodes", $payload)['data']);
    }

    /**
     * Supprime une méthode d'un file.
     *
     * @param  string $fileId  L'id du file sur lequel on souhaite supprimer une méthode.
     * @param  string $context Le context de la méthode.
     * @return File
     */
    public function deleteMethodeFromFile($fileId, $context)
    {
        return new File($this->delete("files/$fileId/methodes/$context")['data']);
    }
}
