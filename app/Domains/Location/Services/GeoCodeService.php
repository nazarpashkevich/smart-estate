<?php

namespace App\Domains\Location\Services;

use App\Domains\Location\Data\GeoCode\GeoCodeData;
use Illuminate\Http\Client\PendingRequest;

class GeoCodeService
{
    public function __construct(private PendingRequest $client)
    {
    }

    public function findByCoords(float $lat, float $lon): GeoCodeData
    {
        return GeoCodeData::from([
            ...$this->makeRequest('reverse', ['lat' => $lat, 'lon' => $lon]),
            ...['lat' => $lat, 'lng' => $lon],
        ]);
    }

    public function makeRequest(string $path, array $params = []): array
    {
        return $this->client->get($path, $params)->json();
    }
}
