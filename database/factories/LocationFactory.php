<?php

namespace Database\Factories;

use App\Domains\Location\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Location\Models\Location>
 */
class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition()
    {
        return [
            'lat'         => $this->faker->latitude,
            'lng'         => $this->faker->longitude,
            'name'        => $this->faker->streetName,
            'postcode'    => $this->faker->postcode,
            'county'      => $this->faker->state,
            'city'        => $this->faker->city,
            'country'     => $this->faker->country,
            'boundingbox' => [],
            'address'     => [
                'street'  => $this->faker->streetAddress,
                'city'    => $this->faker->city,
                'state'   => $this->faker->state,
                'country' => $this->faker->country,
            ],
        ];
    }
}
