<?php

namespace App\Domains\Location\Data\GeoCode;

use App\Domains\Common\Data\Casts\DataCast;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class GeoCodeData extends Data
{
    public function __construct(
        public float $lat,
        public float $lng,
        public ?string $display_name = null,
        public ?array $boundingbox = null,
        #[WithCast(DataCast::class)]
        public ?GeoAddressData $address = null,
    ) {
    }
}
