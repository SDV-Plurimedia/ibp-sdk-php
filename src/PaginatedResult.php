<?php

namespace SdV\Ibp;
use InvalidArgumentException;
use SdV\Ibp\Resources\Resource;

class PaginatedResult
{
    public Resource $items;

    public array $meta;

    public function __construct($items, $meta)
    {
        $this->items = $items;
        $this->meta = $meta;
    }

    /**
     * Renvoie le numéro de la page courante.
     *
     * @throws InvalidArgumentException
     * @return int
     */
    public function currentPage(): int
    {
        if (isset($this->meta['offset_pagination'])) {
            if ($this->meta['offset_pagination']['size']) {
                throw new InvalidArgumentException('Size cannot be 0');
            }

            $currentPage = ceil($this->meta['offset_pagination']['from'] / $this->meta['offset_pagination']['size']);
            if ($currentPage === 0) {
                return 1;
            }

            return $currentPage;
        }

        return $this->meta['pagination']['current_page'];
    }

    /**
     * Renvoie le nombre de pages existantes.
     *
     * @return int
     */
    public function totalPages(): int
    {
        if (isset($this->meta['offset_pagination'])) {
            return ceil($this->total() / $this->perPage());
        }

        return $this->meta['pagination']['total_pages'];
    }

    /**
     * Renvoie le nombre d'items qu'il existe au total.
     *
     * @return int
     */
    public function total(): int
    {
        if (isset($this->meta['offset_pagination'])) {
            return $this->meta['offset_pagination']['total'];
        }

        return $this->meta['pagination']['total'];
    }

    /**
     * Renvoie le nombre d'items par page.
     *
     * @return int
     */
    public function perPage(): int
    {
        if (isset($this->meta['offset_pagination'])) {
            return $this->meta['offset_pagination']['size'];
        }

        return $this->meta['pagination']['per_page'];
    }

    /**
     * Vérifie s'il existe une page suivante.
     *
     * @return boolean
     */
    public function hasNextPage(): bool
    {
        if (isset($this->meta['offset_pagination'])) {
            return $this->currentPage() < $this->totalPages();
        }

        return !empty($this->meta['pagination']['links']['next']);
    }

    /**
     * Vérifie s'il existe une page précédente.
     *
     * @return boolean
     */
    public function hasPreviousPage(): bool
    {
        if (isset($this->meta['offset_pagination'])) {
            return $this->currentPage() > 1;
        }

        return !empty($this->meta['pagination']['links']['previous']);
    }
}
