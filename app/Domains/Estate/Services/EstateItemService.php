<?php

namespace App\Domains\Estate\Services;

use App\Domains\Common\Values\SortValue;
use App\Domains\Estate\Data\EstateItemData;
use App\Domains\Estate\Models\EstateItem;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

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
    public function list(Collection $filters = new Collection(), ?SortValue $sort = null): LengthAwarePaginator
    {
        $query = EstateItem::query();

        $query->filter($filters);

        $sort?->applyTo($query);

        return $query->paginate(2);
    }
}
