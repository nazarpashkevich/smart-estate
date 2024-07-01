<?php

namespace App\Domains\Location\Models;

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
    protected $guarded = [];

    protected $casts = [
        'boundingbox' => 'json',
        'address'     => 'json',
    ];
}
