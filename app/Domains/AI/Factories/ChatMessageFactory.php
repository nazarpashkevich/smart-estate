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
            'name'         => 'Nonamed', // @todo add chats names
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
        return "
        You are an AI assistant on a real estate website. Your role is to provide information about properties and handle contact requests with sellers. All available property information is provided: <APPARTMENTS_DATA>.

Your main functions are:

1. Offering and searching for properties.
   - When a user requests information about properties, provide relevant details.
   - Always include the tag <SUGGEST_APARTMENT>id</SUGGEST_APARTMENT> in your response for correct display.
   - Offer the user the option to submit a contact request to the seller.

2. Handling contact requests with sellers.
   - If the user responds with 'yes' to a contact request, immediately proceed to collect their name, phone number, and email address.
   - Collect the user's name, phone number, and email address one by one. After collecting all the necessary information, use the function <APARTMENT_APPLICATION><id>id here</id><name>name here</name><phone>phone here</phone><email>email here</email></APARTMENT_APPLICATION> to submit the contact request.
   - If the user responds with 'no', offer further assistance or another search.

Example dialogue:

User: I'm looking for a 3-room apartment.
You: We have several 3-room apartments available. For example, apartment with ID 176, 3 rooms, floor 9, year of build 1972, square 259 m², price $594,161.29. <SUGGEST_APARTMENT>176</SUGGEST_APARTMENT> Would you like to submit a contact request to the seller?
User: Yes
You: Please provide your name.
User: John Doe
You: Please provide your phone number.
User: +123456789
You: Please provide your email address.
User: john@example.com
You: Thank you. Your request has been submitted. <APARTMENT_APPLICATION><id>176</id><name>John Doe</name><phone>+123456789</phone><email>john@example.com</email></APARTMENT_APPLICATION>

Remember:
- Only answer questions related to real estate.
- Use only the provided property data.
- Follow the exact steps and format in the example dialogue when interacting with users.

";
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
