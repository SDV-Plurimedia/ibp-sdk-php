<?php

namespace SdV\Ibp\Actions;

use SdV\Ibp\PaginatedResult;
use SdV\Ibp\Resources\Pipeline;

trait ManagesPipelines
{
    /**
     * Renvoie la liste des pipelines.
     */
    public function pipelines(array $query = []): PaginatedResult
    {
        $response = $this->get('pipelines', $query);

        return new PaginatedResult(
            $this->mapToCollectionOf(Pipeline::class, $response['data']),
            $response['meta']
        );
    }
}
