<?php

namespace App\Domains\AI\Factories;

use App\Domains\AI\Assistants\AIAssistant;
use App\Domains\AI\Enums\ChatRole;
use App\Domains\AI\Models\Chat;
use App\Domains\AI\Models\ChatMessage;
use App\Domains\User\Models\User;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ChatMessageFactory
{
    protected Chat $chat;

    protected function __construct(protected User $user, protected string $message)
    {
        $this->chat = $this->makeChat();
    }

    protected function makeChat(): Chat
    {
        return Chat::query()->forUser($this->user)->active()->firstOr(fn () => $this->initChat());
    }

    protected function initChat(): Chat
    {
        $chat = $this->createChat();

        $this->chat = $chat;

        $this->createMessage($this->makeSystemPrompt(), ChatRole::System);
        $this->createMessage($this::getInitMessage(), ChatRole::Assistant);

        return $chat;
    }

    protected function createChat(): Chat
    {
        $chat = new Chat();

        $chat->fill([
            'user_id'      => $this->user->id,
            'name'         => 'Nonamed', // to do add chats names
            'active_until' => Carbon::now()->addHours(2),
        ]);

        $chat->save();

        return $chat;
    }

    protected function createMessage(string $text, ChatRole $role = ChatRole::User): ChatMessage
    {
        /**
         * @var ChatMessage $message
         **/
        $message = $this->chat->messages()->save(new ChatMessage([
            'role' => $role,
            'text' => $text,
        ]));

        return $message;
    }

    protected function makeSystemPrompt(): string
    {
        return '
          ## PROPERTY DATA
           <estate><APPARTMENTS_DATA></estate>

          ## INSTRUCTIONS
           You are an AI assistant expert specialized in real estate.
           Your primary function is to assist users by answering questions related to real estate, suggesting properties,
             asking and submitting property applications, using data in tags <estate></estate>.
             You have to follow instructions and steps very strictly and communicate only in estate domain.


          ## RULES
           When you provide to user information of property data, you must return id of record using the following format: <SUGGEST_APARTMENT>id</SUGGEST_APARTMENT>.
'; //@todo to settings
    }

    public static function getInitMessage(): string
    {
        return "Hello! I'm an AI assistant expert specialized in real estate. How can I assist you today?
         Please feel free to provide me with some context or what's on your mind, and I'll do my best to help!";
    }

    public static function make(User $user, string $message): self
    {
        return new self($user, $message);
    }

    /**
     * @throws \App\Domains\AI\Exceptions\GeneratingAIResponseError
     */
    public function send(bool $streamed = false): StreamedResponse|string
    {
        $this->createMessage($this->message);

        $this->refreshChat();

        // call assistant
        $assistant = app(AIAssistant::class);

        if ($streamed) {
            return $assistant->chat(
                $this->chat,
                fn (string $answer) => $this->createMessage($answer, ChatRole::Assistant)
            );
        }

        $answer = $assistant->chat($this->chat);

        $this->createMessage($answer, ChatRole::Assistant);

        return $answer;
    }

    protected function refreshChat(): void
    {
        $this->chat->update(['active_until' => Carbon::now()->addHours(2)]);
    }
}
