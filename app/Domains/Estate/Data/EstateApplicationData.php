<?php

namespace App\Domains\Estate\Data;

use Akaunting\Money\Money;
use App\Domains\Common\Data\BaseData;
use App\Domains\Common\Data\Casts\PriceCast;
use App\Domains\Common\Data\Transformers\PriceTransformer;
use App\Domains\Estate\Enums\EstateApplicationStatus;
use App\Domains\Estate\Models\EstateApplication;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\EnumCast;

class EstateApplicationData extends BaseData
{
    public function __construct(
        public string $name,
        public string $phone,
        public int $estateItemId,
        #[WithTransformer(PriceTransformer::class)]
        #[WithCast(PriceCast::class)]
        public Money $suggestedPrice,
        #[WithCast(EnumCast::class)]
        public EstateApplicationStatus $status = EstateApplicationStatus::New,
        public ?int $id = null,
    ) {
    }

    public function toModel(int|EstateApplication|null $application = null): EstateApplication
    {
        if (is_int($application)) {
            $application = EstateApplication::query()->findOrFail($application);
        }

        $application ??= new EstateApplication();
        $application->fill([
            'name'            => $this->name,
            'phone'           => $this->phone,
            'suggested_price' => $this->suggestedPrice,
            'status'          => $this->status,
            'estate_item_id'  => $this->estateItemId,
        ]);

        if (!$application->id && Auth::id()) {
            $application->user_id = Auth::id();
        }

        return $application;
    }
}
