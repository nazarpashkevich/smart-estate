<?php

namespace App\Domains\Location\Models;

use Database\Factories\LocationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property float  $lat
 * @property float  $lng
 * @property string $name
 * @property string $postcode
 * @property string $county
 * @property string $country
 * @property array  $boundingbox
 * @property array  $address
 */
class Location extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'boundingbox' => 'array',
        'address'     => 'json',
    ];

    protected static function newFactory(): LocationFactory|\Illuminate\Database\Eloquent\Factories\Factory
    {
        return LocationFactory::new();
    }
}
