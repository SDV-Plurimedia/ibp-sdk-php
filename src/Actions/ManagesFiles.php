<?php

namespace SdV\Ibp\Actions;

use SdV\Ibp\Exceptions\ApiException;
use SdV\Ibp\PaginatedResult;
use SdV\Ibp\Resources\Error;
use SdV\Ibp\Resources\File;

trait ManagesFiles
{
    /**
     * Renvoie la liste des files.
     *
     * @return File[]
     */
    public function files(array $query = []): PaginatedResult
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
    public function file(string $fileId): File
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
    public function tagFile(string $fileId, string $service, ?array $tags = null): File
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
    public function putExtras($fileId, $data): File
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
    public function upsertMethodeOnFile($fileId, $payload): File
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
    public function deleteMethodeFromFile(string $fileId, string $context): File
    {
        return new File($this->delete("files/$fileId/methodes/$context")['data']);
    }

    /**
     * Supprime un fichier d'IBP
     * @param string $fileId L'id du fichier que l'on souhaite supprimer.
     * @param boolean $forceDelete Supprime le fichier définitivement.
     * @return boolean
     */
    public function deleteFile(string $fileId, bool $forceDelete = false): bool
    {
        $payload = [
            'force_delete' => $forceDelete,
            'data' => [$fileId]
        ];
        $response = $this->delete('files', $payload);

        if (array_key_exists('errors', $response['data']) && !empty($response['data']['errors'])) {
            throw new ApiException('Cannot delete file ' . $fileId, new Error([
                'title' => $response['data']['errors'][0]['title'],
                'messages' => $response['data']['errors'][0]['message'],
                'status' => 500
            ]));
        }

        return true;
    }

    /**
     * Active / desactive le mode de detection intelligente de Thumbor pour un fichier
     * @param string $fileId L'id du fichier que l'on souhaite supprimer.
     * @param boolean $value
     * @return boolean
     */
    public function setSmartMode(string $fileId, bool $value): bool
    {
        $this->put("files/$fileId/smart", [
            'smart' => $value,
        ]);

        return true;
    }
}
