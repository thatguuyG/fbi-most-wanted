<?php



// app/Application/Handlers/WantedHandler.php
namespace App\Handlers;

use App\UseCases\FetchWantedListUseCase;
use Illuminate\Http\JsonResponse;

class WantedHandler
{
    protected FetchWantedListUseCase $fetchWantedListUseCase;

    public function __construct(FetchWantedListUseCase $fetchWantedListUseCase)
    {
        $this->fetchWantedListUseCase = $fetchWantedListUseCase;
    }

    public function handleFetchData(): array
    {
        $filters = request()->all();
        return (array) $this->fetchWantedListUseCase->execute($filters);
    }
}
