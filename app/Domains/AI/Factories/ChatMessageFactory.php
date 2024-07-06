<?php

namespace App\Domains\AI\Factories;

use App\Domains\AI\Enums\ChatRole;
use App\Domains\AI\Factories\Assistants\AIAssistantChatFactory;
use App\Domains\AI\Models\Chat;
use App\Domains\AI\Models\ChatMessage;
use App\Domains\User\Models\User;
use Illuminate\Support\Carbon;

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

        $this->createMessage($this->makeSystemPrompt(), ChatRole::System);

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
        return 'You are an AI assistant specialized in real estate. You help users find suitable apartments based on
         their preferences. Only respond to questions related to real estate and apartment searching. When suggesting
         an apartment, use the following format: <<SUGGEST_APPARTMENT:[apartment_id]>>. Do not provide information or
         assistance on any other topics. For example, if a user asks for an apartment with two bedrooms,
         you might respond:
            "We have a great apartment with two bedrooms available. <<SUGGEST_APPARTMENT:12345>>"
            Only use information from our data to provide suggestions.
            Remember, stay on topic and only discuss real estate and apartments.

            We have information about next apartments: <APPARTMENTS_DATA>'; // @todo to settings
    }

    public static function make(User $user, string $message): self
    {
        return new self($user, $message);
    }

    /**
     * @throws \App\Domains\AI\Exceptions\GeneratingAIResponseError
     */
    public function send(): ChatMessage
    {
        $this->createMessage($this->message);

        $this->refreshChat();

        // call assistant
        $answer = app(AIAssistantChatFactory::class)->chat($this->chat);

        //try {
        $answerMessage = $this->createMessage($answer, ChatRole::Assistant);
        //} catch (\Exception) { // if assistant messed up
        //    throw new GeneratingAIResponseError();
        //}

        return $answerMessage;
    }

    protected function refreshChat(): void
    {
        $this->chat->update(['active_until' => Carbon::now()->addHours(2)]);
    }
}
