<?php

namespace App\Domains\AI\Services;

use App\Domains\AI\Enums\ChatRole;
use App\Domains\AI\Factories\ChatMessageFactory;
use App\Domains\AI\Models\Chat;
use App\Domains\User\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ChatService
{

    /**
     * @return \Illuminate\Support\Collection<\App\Domains\AI\Data\ChatMessageData>
     */
    public function history(User $user): Collection
    {
        return $this->activeChat($user)
                   ?->messages()
                   ->whereNot('role', ChatRole::System)
                   ->orderBy('id')
                   ->get() ?? new Collection();
    }

    public function activeChat(User $user): ?Chat
    {
        return Chat::query()
            ->forUser($user)
            ->active()
            ->first();
    }

    /**
     * RETURNS STREAMED CONTENT!
     *
     * @throws \App\Domains\AI\Exceptions\GeneratingAIResponseError
     */
    public function sendStreamed(User $user, string $message): StreamedResponse
    {
        return ChatMessageFactory::make($user, $message)->send(true);
    }

    public function clear(User|Authenticatable $user): void
    {
        $this->activeChat($user)->delete();
    }
}
