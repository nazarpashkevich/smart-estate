<?php

namespace App\Domains\AI\Resolvers\MessageResolvers;

use App\Domains\AI\Contracts\AssistantMessageResolver;
use App\Domains\Estate\Models\EstateItem;
use Illuminate\Support\Str;

class GeneralAssistantMessageResolver implements AssistantMessageResolver
{
    public function resolve(string $message): string
    {
        return Str::replace(['<APPARTMENTS_DATA>'], [$this->getApartmentsData()], $message);
    }

    public function getApartmentsData(): string
    {
        return EstateItem::query()->get()->toJson();
    }
}
