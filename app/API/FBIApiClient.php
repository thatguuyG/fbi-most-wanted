<?php

namespace App\API;

use App\DTO\WantedPersonDTO;

class FBIApiClient
{

    public function getList(array $params = []): array
    {
        $baseUrl = config('fbi.api_url');
        $response = get("{$baseUrl}/list", $params);
        // \Log::info($response->items);
        $res = (array) $response;
        $wantedPersons = collect($res['items'] ?? [])
            ->map(fn($item) => WantedPersonDTO::fromArray((array) $item))
            ->toArray();
        return $wantedPersons;
    }
}
