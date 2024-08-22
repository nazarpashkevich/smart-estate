<?php

namespace App\Domains\AI\Factories;

use App\Domains\AI\Assistants\AIAssistant;
use App\Domains\AI\Enums\ChatRole;
use App\Domains\AI\Models\Chat;
use App\Domains\AI\Models\ChatMessage;
use App\Domains\Estate\Data\EstateApplicationData;
use App\Domains\Estate\Models\EstateItem;
use App\Domains\Estate\Services\EstateApplicationService;
use App\Domains\User\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ChatMessageFactory
{
    protected Chat $chat;
    protected EstateApplicationService $applicationService;

    protected function __construct(protected User $user, protected string $message)
    {
        $this->chat = $this->makeChat();
        $this->applicationService = app(EstateApplicationService::class);
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
        // check for application
        if ($role === ChatRole::Assistant) {
            $this->checkApplicationInAnswer($text);
        }

        /**
         * @var ChatMessage $message
         **/
        $message = $this->chat->messages()->save(new ChatMessage([
            'role' => $role,
            'text' => $text,
        ]));

        return $message;
    }

    public function checkApplicationInAnswer(string &$answer): void
    {
        $pattern = '/<APARTMENT_APPLICATION>.*?<\/APARTMENT_APPLICATION>/s';
        if (preg_match($pattern, $answer, $matches)) {
            $xmlString = $matches[0];
            $xmlString = trim($xmlString);

            $application = json_decode(json_encode(simplexml_load_string($xmlString)), true);
            if ($application) {
                $estate = EstateItem::query()->find($application['id']);

                $this->applicationService->create(new EstateApplicationData(
                    $application['name'],
                    $application['phone'],
                    $estate->id,
                    $estate->price
                ));

                $answer = Str::replace($matches[0], '', $answer);
            }
        }
    }

    protected function makeSystemPrompt(): string
    {
        return config('ai.init_prompt');
    }

    public static function getInitMessage(): string
    {
        return config('ai.init_message');
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
