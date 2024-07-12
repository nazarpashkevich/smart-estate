<?php

namespace App\Domains\Estate\Http\Controllers\Api;

use App\Domains\Estate\Data\EstateItemData;
use App\Domains\Estate\Models\EstateItem;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;

class ApiEstateController
{
    use ApiResponseHelpers;

    public function show(EstateItem $estateItem): JsonResponse
    {
        $estateItem->load('location');

        return $this->respondWithSuccess(['data' => EstateItemData::from($estateItem)]);
    }
}
