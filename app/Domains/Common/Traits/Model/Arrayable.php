<?php

namespace App\Domains\Common\Traits\Model;

use Illuminate\Support\Str;

trait Arrayable
{
    public function toArray(): array
    {
        $item = parent::toArray();

        return array_combine(array_map([Str::class, 'camel'], array_keys($item)), array_values($item));
    }
}
