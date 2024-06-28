<?php

namespace App\Domains\Common\Traits\Request;

use App\Domains\Common\Values\SortValue;

trait WithSorting
{

    public function sortingRules(): array
    {
        return [
            'sort' => ['string'],
        ];
    }

    public function sort(): ?SortValue
    {
        $sort = $this->str('sort');
        if ($sort != '') {
            $sortParts = explode(':', $sort, 2);

            return SortValue::make(...$sortParts);
        }

        return null;
    }
}
