<?php

namespace App\Domains\Estate\Http\Controllers;

use App\Domains\Estate\Data\EstateItemData;
use App\Domains\Estate\Http\Requests\EstateItemRequest;
use App\Domains\Estate\Services\EstateItemService;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class PersonalEstateController
{
    use ApiResponseHelpers;

    public function __construct(protected EstateItemService $service)
    {
    }

    public function index(): \Inertia\Response
    {
        return Inertia::render('Personal/Estate/Index', [
            'items' => EstateItemData::toWrap($this->service->list()),
        ]);
    }

    public function store(EstateItemRequest $request): RedirectResponse
    {
        $this->service->create($request->toData());

        return redirect(route('personal.estate.index'));
    }

    public function create(): \Inertia\Response
    {
        return Inertia::render('Personal/Estate/Create');
    }
}
