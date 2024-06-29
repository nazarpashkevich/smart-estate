<?php

namespace App\Domains\Estate\Http\Controllers;

use App\Domains\Estate\Data\EstateItemData;
use App\Domains\Estate\Http\Requests\EstateItemsRequest;
use App\Domains\Estate\Models\EstateItem;
use App\Domains\Estate\Services\EstateItemService;
use F9Web\ApiResponseHelpers;
use Inertia\Inertia;

class EstateController
{
    use ApiResponseHelpers;

    public function __construct(protected EstateItemService $service)
    {
    }

    public function show(EstateItem $estateItem): \Inertia\Response
    {
        return Inertia::render('Personal/Estate/Index', [

        ]);
    }


    public function index(EstateItemsRequest $request): \Inertia\Response
    {
        $filters = $request->filters();

        return Inertia::render('Estate/Index', [
            'items'   => EstateItemData::toWrap($this->service->list(filters: $filters, sort: $request->sort())),
            'filters' => $filters,
        ]);
    }
}
