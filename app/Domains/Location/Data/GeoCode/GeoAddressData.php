<?php

namespace App\Domains\Location\Data\GeoCode;

use Spatie\LaravelData\Data;

class GeoAddressData extends Data
{
    public function __construct(
        public string $country,
        public string $postcode,
        public string $country_code,
        public string $county = '',
        public string $hamlet = '',
        public string $city = '',
        public string $village = '',
    ) {
    }
}
