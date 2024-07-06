<?php

namespace App\Domains\AI\Models;

use App\Domains\AI\Enums\ChatRole;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property \App\Domains\AI\Enums\ChatRole $role
 * @property string                         $text
 */
class ChatMessage extends Model
{
    protected $guarded = [];

    protected $casts = [
        'role' => ChatRole::class,
    ];
    
}
