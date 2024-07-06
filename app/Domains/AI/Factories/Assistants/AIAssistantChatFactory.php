<?php

namespace App\Domains\AI\Factories\Assistants;

use App\Domains\AI\Contracts\AssistantMessageResolver;
use App\Domains\AI\Models\Chat;
use App\Domains\AI\Models\ChatMessage;
use Illuminate\Support\Collection;

abstract class AIAssistantChatFactory
{
    public function chat(Chat $chat): string
    {
        return $this->generateAnswer($this->makeHistory($chat));
    }

    abstract function generateAnswer(Collection $messages): string;

    public function makeHistory(Chat $chat): Collection
    {
        $chat->loadMissing('messages');

        return $chat->messages->map(
            fn (ChatMessage $message) => ['role' => $message->role, 'content' => $this->resolveMessage($message->text)]
        );
    }

    public function resolveMessage(string $message): string
    {
        return app(AssistantMessageResolver::class)->resolve($message);
    }
}
