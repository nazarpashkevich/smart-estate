<?php

namespace App\Domains\Estate\Services;

use App\Domains\Common\Values\SortValue;
use App\Domains\Estate\Data\EstateApplicationData;
use App\Domains\Estate\Models\EstateApplication;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EstateApplicationService
{

    public function create(EstateApplicationData $data): EstateApplication
    {
        $estateItem = $data->toModel();
        $estateItem->save();

        return $estateItem;
    }

    public function update(EstateApplication $estateItem, EstateApplicationData $data): EstateApplication
    {
        $estateItem = $data->toModel($estateItem);
        $estateItem->save();

        return $estateItem;
    }

    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator<\App\Domains\Estate\Models\EstateApplication>
     */
    public function list(Collection $filters = new Collection(), ?SortValue $sort = null): LengthAwarePaginator
    {
        $query = EstateApplication::query()->with('location');

        //$query->filter($filters);

        //$sort?->applyTo($query);

        return $query->paginate(2);
    }
}
