<?php

namespace SdV\Ibp\Actions;

use SdV\Ibp\Resources\File;

trait ManagesUploads
{
    /**
     * Upload un file.
     *
     * @param  stream $fileContent Le contenu du file.
     * @param  array $payload    Les données supplémentaires à transmettre.
     * @return File
     */
    public function uploadFile($fileContent, array $payload = [])
    {
        return new File($this->upload('files', $fileContent, $payload)['data']);
    }

    /**
     * Upload un fichier depuis son contenu.
     * @param string $fileContent le contenu du fichier.
     * @param string $fileName le nom du fichier (qui sera uploadé sur IBP).
     * @param array $payload Les données supplémentaires à transmettre.
     * @return File
    */
    public function uploadFileFromContent($fileContent, $fileName, array $payload = [])
    {
        return new File($this->uploadFromContent('files', $fileContent, $fileName, $payload)['data']);
    }
}
