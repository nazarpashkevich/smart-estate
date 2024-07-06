<?php

namespace App\Domains\AI\Services;

use App\Domains\AI\Factories\ChatMessageFactory;
use App\Domains\AI\Models\Chat;
use App\Domains\AI\Models\ChatMessage;
use App\Domains\User\Models\User;
use Illuminate\Support\Collection;

class ChatService
{

    /**
     * @return \Illuminate\Support\Collection<\App\Domains\AI\Data\ChatMessageData>
     */
    public function history(User $user): Collection
    {
        return Chat::query()
                   ->forUser($user)
                   ->active()
                   ->first()
                   ?->messages()
                   ->orderBy('id')
                   ->get() ?? [];
    }

    public function send(User $user, string $message): ChatMessage
    {
        return ChatMessageFactory::make($user, $message)->send();
    }
}
