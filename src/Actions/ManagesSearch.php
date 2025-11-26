<?php

namespace SdV\Ibp\Actions;

use SdV\Ibp\Resources\File;
use SdV\Ibp\PaginatedResult;

trait ManagesSearch
{
    /**
     * Renvoie la liste des files.
     */
    public function searchFiles(array $query = []): PaginatedResult
    {
        $response = $this->get('files/search', $query);

        return new PaginatedResult(
            $this->mapToCollectionOf(File::class, $response['data']),
            $response['meta']
        );
    }
}
