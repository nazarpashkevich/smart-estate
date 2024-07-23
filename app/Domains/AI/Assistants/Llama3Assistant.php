<?php

namespace App\Domains\AI\Assistants;

use App\Domains\Estate\Models\EstateItem;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Llama3Assistant extends AIAssistant
{
    const MODEL_CODE = 'llama3:latest';


    public function __construct(protected PendingRequest $client)
    {
    }

    /**
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function generateAnswer(Collection $messages, bool $streamed = false): StreamedResponse|string
    {
        $response = $this->client->send('POST', 'api/chat', [
            'body'   => json_encode(
                [
                    'model'      => $this::MODEL_CODE,
                    'messages'   => $messages->toArray(),
                    'stream'     => $streamed,
                    'keep_alive' => "20m",
                    'options'    => [
                        'num_ctx'     => 8192,
                        'temperature' => 0.7,
                        'top_k'       => 20,
                        'top_p'       => 0.8,
                    ],
                ]
            ),
            'stream' => true,
        ]);

        return $this->parseStreamedResponse($response->toPsrResponse()->getBody());
    }

    public function test()
    {
        $response = $this->client->post(
            'api/embeddings',
            ['model' => 'mxbai-embed-large', 'prompt' => EstateItem::query()->get()->toJson()]
        );
        dd($response->body());
    }
}
