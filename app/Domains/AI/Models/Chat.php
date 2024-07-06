<?php

namespace App\Domains\AI\Models;

use App\Domains\AI\Builders\ChatBuilder;
use App\Domains\Common\Traits\Model\InteractWithBuilder;
use App\Domains\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string                                                                       $name
 * @property \Carbon\CarbonInterface                                                      $active_until
 * @property \Illuminate\Database\Eloquent\Collection<\App\Domains\AI\Models\ChatMessage> $messages
 *
 * @method static \App\Domains\AI\Builders\ChatBuilder query()
 */
class Chat extends Model
{
    use InteractWithBuilder;

    public string $customBuilder = ChatBuilder::class;

    protected $casts = [
        'active_until' => 'datetime',
    ];

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }
}
