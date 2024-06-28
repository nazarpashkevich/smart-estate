<?php

namespace App\Domains\Estate\Services;

use App\Domains\Common\Values\SortValue;
use App\Domains\Estate\Data\EstateItemData;
use App\Domains\Estate\Models\EstateItem;
use Illuminate\Pagination\LengthAwarePaginator;

class EstateItemService
{

    public function create(EstateItemData $data): EstateItem
    {
        $estateItem = $data->toModel();
        $estateItem->save();

        return $estateItem;
    }

    public function update(EstateItem $estateItem, EstateItemData $data): EstateItem
    {
        $estateItem = $data->toModel($estateItem);
        $estateItem->save();

        return $estateItem;
    }

    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator<\App\Domains\Estate\Models\EstateItem>
     */
    public function list(?SortValue $sort = null): LengthAwarePaginator
    {
        $query = EstateItem::query();

        $sort?->applyTo($query);

        return $query->paginate(2);
    }
}
