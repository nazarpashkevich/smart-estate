<?php

namespace App\Domains\AI\Contracts;

interface AssistantMessageResolver
{
    public function resolve(string $message): string;
}
