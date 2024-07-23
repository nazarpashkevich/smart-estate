<?php

namespace App\Domains\AI\Enums;

enum ChatRole: string
{
    case System = 'system';
    case Assistant = 'assistant';
    case User = 'user';
}
