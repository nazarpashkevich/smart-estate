<?php

namespace App\Domains\Common\Casts;

use Akaunting\Money\Currency;
use Akaunting\Money\Money;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class MoneyCast implements CastsAttributes
{

    /**
     * @inheritDoc
     */
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        return new Money($value, new Currency('usd'));
    }

    /**
     * @inheritDoc
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof Money) {
            return $value->getAmount();
        }

        return $value;
    }
}
