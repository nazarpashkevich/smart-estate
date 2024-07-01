<?php

namespace App\Domains\Common\Data\Transformers;

use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Transformation\TransformationContext;
use Spatie\LaravelData\Transformers\Transformer;

class PriceTransformer implements Transformer
{

    /**
     * @param  \Spatie\LaravelData\Support\DataProperty                          $property
     * @param  \Akaunting\Money\Money                                            $value
     * @param  \Spatie\LaravelData\Support\Transformation\TransformationContext  $context
     *
     * @return mixed
     */
    public function transform(DataProperty $property, mixed $value, TransformationContext $context): mixed
    {
        return [
            'value'  => $value->getValue(),
            'format' => $value->format(),
        ];
    }
}
