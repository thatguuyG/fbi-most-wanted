<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Handlers\WantedHandler;
use App\Interfaces\WantedRepositoryInterface;
use App\UseCases\FetchWantedListUseCase;

class MostWantedApi extends Controller
{

    protected WantedHandler $handler;
    protected FetchWantedListUseCase $fetchWantedListUseCase;

    public function __construct(WantedHandler $handler, FetchWantedListUseCase $fetchWantedListUseCase)
    {
        $this->fetchWantedListUseCase = $fetchWantedListUseCase;
        $this->handler = new WantedHandler($this->fetchWantedListUseCase);
    }

    public function getData(Request $request)
    {
        $data = $this->handler->handleFetchData($request->all());
        return result("FBI most wanted fetched successfully", $data);
    }
}
