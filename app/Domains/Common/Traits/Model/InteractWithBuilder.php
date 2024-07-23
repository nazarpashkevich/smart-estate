<?php

namespace App\Domains\Common\Traits\Model;

use RuntimeException;

/**
 * @property string $customBuilder
 */
trait InteractWithBuilder
{
    public function newEloquentBuilder($query)
    {
        if (!$this->customBuilder) {
            throw new RuntimeException('Set $builder needed in ' . self::class);
        }

        return new $this->customBuilder($query);
    }
}
