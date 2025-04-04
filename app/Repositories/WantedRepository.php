<?php

namespace App\Repositories;

use App\Interfaces\WantedRepositoryInterface;
use App\API\FBIApiClient;

class WantedRepository implements WantedRepositoryInterface
{
    protected FBIApiClient $apiClient;

    public function __construct(FBIApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function fetchList(array $filters = []): array
    {
        return $this->apiClient->getList($filters);
    }
}
