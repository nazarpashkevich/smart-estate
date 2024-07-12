<?php

namespace App\Domains\AI\Services;

use App\Domains\AI\Enums\ChatRole;
use App\Domains\AI\Factories\ChatMessageFactory;
use App\Domains\AI\Models\Chat;
use App\Domains\User\Models\User;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
                   ->whereNot('role', ChatRole::System)
                   ->orderBy('id')
                   ->get() ?? new Collection();
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
}
