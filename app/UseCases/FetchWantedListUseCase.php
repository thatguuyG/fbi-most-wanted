<?php


namespace App\UseCases;

use App\DTO\WantedPersonDTO;
use App\Interfaces\WantedRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class FetchWantedListUseCase
{
    protected WantedRepositoryInterface $repository;

    public function __construct(WantedRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(array $filters = [])
    {
        // $items = $filters['items'] ?? [];
        // $total = $filters['total'] ?? count($items);
        // $perPage = $filters['per_page'] ?? 10;
        // $currentPage = $filters['page'] ?? 1;

        // $paginator = new LengthAwarePaginator(
        //     $items,
        //     $total,
        //     $perPage,
        //     $currentPage,
        //     [
        //         'path' => request()->url()
        //     ]
        // );

        // return $paginator;

        return $this->repository->fetchList($filters);
    }
}
