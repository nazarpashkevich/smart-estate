<?php

namespace App\Domains\AI\Factories\Assistants;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;

class Llama3AssistantFactory extends AIAssistantChatFactory
{
    const MODEL_CODE = 'llama3:latest';


    public function __construct(protected PendingRequest $client)
    {
    }

    /**
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function generateAnswer(Collection $messages): string
    {
        $result = $this->client->post(
            'api/chat',
            ['model' => $this::MODEL_CODE, 'messages' => $messages->toArray(), 'stream' => false] // @todo make stream
        );

        return $result->json()['message']['content'];
    }
}
