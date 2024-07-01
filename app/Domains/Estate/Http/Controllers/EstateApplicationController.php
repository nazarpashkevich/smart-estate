<?php

namespace App\Domains\Estate\Http\Controllers;

use App\Domains\Estate\Data\EstateApplicationData;
use App\Domains\Estate\Http\Requests\EstateApplicationRequest;
use App\Domains\Estate\Models\EstateApplication;
use App\Domains\Estate\Services\EstateApplicationService;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class EstateApplicationController
{
    use ApiResponseHelpers;

    public function __construct(protected EstateApplicationService $service)
    {
    }


    public function index($request): \Inertia\Response
    {
        // @todo
        return Inertia::render('Estate/Index', [
            'items' => EstateApplicationData::toWrap($this->service->list()),
        ]);
    }

    public function show(EstateApplication $estateApplication): \Inertia\Response
    {
        // @todo

        return Inertia::render('', [
            'item' => EstateApplicationData::from($estateApplication),
        ]);
    }

    public function store(EstateApplicationRequest $request): RedirectResponse
    {
        $this->service->create($request->toData());

        return back();
    }
}
