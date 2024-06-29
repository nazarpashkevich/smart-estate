<?php

namespace App\Domains\Common\Traits\Model;

use RuntimeException;

/**
 * @property string $customFilter
 */
trait InteractWithFilter
{
    public function getFilter(): string
    {
        if (!$this->customFilter) {
            throw new RuntimeException('Set $customFilter needed in ' . self::class);
        }

        return $this->customFilter;
    }
}
