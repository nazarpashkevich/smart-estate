<?php

namespace App\Domains\AI\Assistants;

use Illuminate\Support\Collection;
use LLPhant\Chat\Enums\ChatRole;
use LLPhant\Chat\Message;
use LLPhant\Chat\OllamaChat;
use LLPhant\Embeddings\EmbeddingGenerator\Ollama\OllamaEmbeddingGenerator;
use LLPhant\Embeddings\VectorStores\Elasticsearch\ElasticsearchVectorStore;
use LLPhant\Query\SemanticSearch\QuestionAnswering;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Llama3VectorableAssistant extends AIAssistant
{
    public function __construct(
        protected OllamaChat $chat,
        protected OllamaEmbeddingGenerator $embeddingGenerator,
        protected ElasticsearchVectorStore $vectorStore
    ) {
    }

    public function generateAnswer(Collection $messages, bool $streamed = false): StreamedResponse|string
    {
        //Once the vectorStore is ready, you can then use the QuestionAnswering class to answer questions
        $qa = new QuestionAnswering($this->vectorStore, $this->embeddingGenerator, $this->chat);

        return $this->parseStreamedResponse(
            $qa->answerQuestionFromChat($messages->map(function (array $message): Message {
                $chatMsg = new Message();
                $chatMsg->content = $message['content'];
                $chatMsg->role = ChatRole::from($message['role']->value);

                return $chatMsg;
            })->toArray())
        );
    }
}
