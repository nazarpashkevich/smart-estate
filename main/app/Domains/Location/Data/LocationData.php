<?php

namespace App\Domains\Location\Data;

use App\Domains\Location\Models\Location;
use App\Domains\Location\Services\LocationService;
use Spatie\LaravelData\Data;

class LocationData extends Data
{
    public function __construct(
        public float $lat,
        public float $lng,
        public ?string $name = null,
        public ?string $postcode = null,
        public ?string $county = null,
        public ?string $city = null,
        public ?string $country = null,
        public ?array $boundingbox = null,
        public ?array $address = null,
    ) {
    }

    public function toModel(): Location
    {
        return app(LocationService::class)->make($this);
    }
}
