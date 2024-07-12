<?php

namespace App\Domains\AI\Assistants;

use App\Domains\AI\Contracts\AssistantMessageResolver;
use App\Domains\AI\Models\Chat;
use App\Domains\AI\Models\ChatMessage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

abstract class AIAssistant
{
    protected \Closure $callback;

    /**
     * if callback provided - streamable response
     *
     * @param  \App\Domains\AI\Models\Chat  $chat
     * @param  \Closure|null                $callback
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|string
     */
    public function chat(Chat $chat, ?\Closure $callback = null): StreamedResponse|string
    {
        $this->callback = $callback;

        return $this->generateAnswer($this->makeHistory($chat), $callback instanceof \Closure);
    }

    abstract function generateAnswer(Collection $messages, bool $streamed = false): StreamedResponse|string;

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

    public function parseStreamedResponse(StreamInterface $body): StreamedResponse
    {
        return new StreamedResponse(function () use ($body) {
            $buffer = '';
            $depth = 0;
            $message = '';

            while (!$body->eof()) {
                $char = $body->read(1);
                Log::info("char " . $char);
                $buffer .= $char;

                if ($char === '{') {
                    $depth++;
                } elseif ($char === '}') {
                    $depth--;
                }

                if ($depth === 0 && trim($buffer) !== '') {
                    $json = trim($buffer);

                    $buffer = '';
                    try {
                        $data = json_decode($json);

                        if (isset($data->message->content)) {
                            echo $data->message->content;
                            $message .= $data->message->content;
                            ob_flush();
                            flush();
                        }
                    } catch (\Exception) {
                    }
                }
            }
            call_user_func($this->callback, $message);
        }, 200, [
            'Cache-Control'     => 'no-cache',
            'X-Accel-Buffering' => 'no',
            'Content-Type'      => 'text/event-stream',
        ]);
    }
}
