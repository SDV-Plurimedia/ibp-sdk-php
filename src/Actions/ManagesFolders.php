<?php

namespace SdV\Ibp\Actions;

use SdV\Ibp\PaginatedResult;
use SdV\Ibp\Resources\Folder;
use SdV\Ibp\Resources\File;

trait ManagesFolders
{
    /**
     * Renvoie la liste des folders.
     */
    public function folders(array $query = []): PaginatedResult
    {
        $response = $this->get('folders', $query);

        return new PaginatedResult(
            $this->mapToCollectionOf(Folder::class, $response['data']),
            $response['meta']
        );
    }

    /**
     * Renvoie un folder.
     */
    public function folder(string $folderId): Folder
    {
        return new Folder($this->get("folders/$folderId")['data']);
    }

	/**
	 * Renvoie la liste des fichiers d'un folder.
	 */
	public function folderFiles(string $folderId, array $query = []): PaginatedResult
	{
		$response = $this->get("folders/$folderId/files", $query);

		return new PaginatedResult(
			$this->mapToCollectionOf(File::class, $response['data']),
			$response['meta']
		);
	}

    /**
     * Crée un nouveau folder.
     */
    public function createFolder(string $name): Folder
    {
        return new Folder($this->post('folders', ['name' => $name])['data']);
    }

    /**
     * Met à jour un folder.
     */
    public function updateFolder(string $folderId, string $name): Folder
    {
        $response = $this->put("folders/$folderId", ['name' => $name]);

        return new Folder($response['data']);
    }

    /**
     * Ajoute un file dans un folder.
     */
    public function addFileInFolder(string $folderId, string $fileId): Folder
    {
        $response = $this->post("folders/$folderId/files", [
            'file_id' => $fileId,
        ]);

        return new Folder($response['data']);
    }

    /**
     * Enleve un file du folder.
     */
    public function removeFileFromFolder(string $folderId, string $fileId): bool
    {
        $this->delete("folders/$folderId/files/$fileId");

        return true;
    }
}
