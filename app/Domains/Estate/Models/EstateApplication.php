<?php

namespace App\Domains\Estate\Models;

use App\Domains\Common\Casts\MoneyCast;
use App\Domains\Common\Traits\Model\Arrayable;
use App\Domains\Estate\Enums\EstateApplicationStatus;
use App\Domains\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int                                               $id
 * @property string                                            $name
 * @property string                                            $phone
 * @property \Akaunting\Money\Money                            $suggested_price
 * @property \App\Domains\Estate\Enums\EstateApplicationStatus $status
 * @property \App\Domains\User\Models\User                     $user
 */
class EstateApplication extends Model
{
    use Arrayable;

    protected $guarded = [];

    protected $casts = [
        'status'          => EstateApplicationStatus::class,
        'suggested_price' => MoneyCast::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
