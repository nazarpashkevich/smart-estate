<?php

namespace App\Domains\Estate\Http\Controllers;

use App\Domains\Estate\Data\EstateApplicationData;
use App\Domains\Estate\Http\Requests\EstateApplicationRequest;
use App\Domains\Estate\Http\Requests\EstateApplicationsRequest;
use App\Domains\Estate\Http\Requests\UpdateEstateApplicationStatusRequest;
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


    public function index(EstateApplicationsRequest $request): \Inertia\Response
    {
        // @todo
        return Inertia::render('Personal/Applications/Index', [
            'items'   => EstateApplicationData::toWrap($this->service->list($request->filters(), $request->sort())),
            'filters' => $request->filters(),
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

    public function updateStatus(
        EstateApplication $estateApplication,
        UpdateEstateApplicationStatusRequest $request
    ): RedirectResponse {
        $data = $estateApplication->toData();
        $data->status = $request->status();

        $this->service->update($estateApplication, $data);

        return redirect(route('personal.application.index'));
    }
}
