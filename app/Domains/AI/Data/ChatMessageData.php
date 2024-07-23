<?php

namespace App\Domains\AI\Data;

use App\Domains\AI\Enums\ChatRole;
use Carbon\CarbonInterface;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;

class ChatMessageData extends Data
{
    public function __construct(
        public int $id,
        #[WithCast(EnumCast::class)]
        public ChatRole $role,
        public string $text,
        public CarbonInterface $created_at
    ) {
    }
}
