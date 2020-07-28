<?php

namespace SdV\Ibp\Actions;

use SdV\Ibp\PaginatedResult;
use SdV\Ibp\Resources\Folder;
use SdV\Ibp\Resources\File;

trait ManagesFolders
{
    /**
     * Renvoie la liste des folders.
     *
     * @return Folder[]
     */
    public function folders(array $query = [])
    {
        $response = $this->get('folders', $query);

        return new PaginatedResult(
            $this->mapToCollectionOf(Folder::class, $response['data']),
            $response['meta']
        );
    }

    /**
     * Renvoie un folder.
     *
     * @param  string $folderId
     * @return Folder
     */
    public function folder($folderId)
    {
        return new Folder($this->get("folders/$folderId")['data']);
    }

	/**
	 * Renvoie la liste des fichiers d'un folder.
	 *
	 * @param  string $folderId
	 * @return PaginatedResult
	 */
	public function folderFiles($folderId, array $query = [])
	{
		$response = $this->get("folders/$folderId/files", $query);

		return new PaginatedResult(
			$this->mapToCollectionOf(File::class, $response['data']),
			$response['meta']
		);
	}

    /**
     * Crée un nouveau folder.
     *
     * @param  string $name Le nom du folder.
     * @return Folder
     */
    public function createFolder($name)
    {
        return new Folder($this->post('folders', ['name' => $name])['data']);
    }

    /**
     * Met à jour un folder.
     *
     * @param  string $folderId L'identifiant du folder.
     * @param  string $name Le nouveau nom du folder.
     * @return Folder
     */
    public function updateFolder($folderId, $name)
    {
        $response = $this->put("folders/$folderId", ['name' => $name]);

        return new Folder($response['data']);
    }

    /**
     * Ajoute un file dans un folder.
     *
     * @param  string $folderId L'identifiant du folder.
     * @param  string $fileId L'identifiant du file.
     */
    public function addFileInFolder($folderId, $fileId)
    {
        $response = $this->post("folders/$folderId/files", [
            'file_id' => $fileId,
        ]);

        return new Folder($response['data']);
    }

    /**
     * Enleve un file du folder.
     *
     * @param  string $folderId L'identifiant du folder.
     * @param  string $fileId L'identifiant du file.
     * @return boolean|Exception
     */
    public function removeFileFromFolder($folderId, $fileId)
    {
        $this->delete("folders/$folderId/files/$fileId");

        return true;
    }
}
