<?php

namespace App\LIbraries\LipHant;

use LLPhant\Exception\HttpException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class OllamaChat extends \LLPhant\Chat\OllamaChat
{
    /**
     * OVERWRITTEN: because library miss stream parameter
     *
     * Send the HTTP request to Ollama API endpoint
     *
     * @param  mixed[]  $json
     *
     * @see https://github.com/ollama/ollama/blob/main/docs/api.md
     */
    protected function sendRequest(string $method, string $path, array $json): ResponseInterface
    {
        $response = $this->client->request($method, $path, ['json' => $json, 'stream' => true,]);
        $status = $response->getStatusCode();
        if ($status < 200 || $status >= 300) {
            throw new HttpException(sprintf(
                'HTTP error from Ollama (%d): %s',
                $status,
                $response->getBody()->getContents()
            ));
        }

        return $response;
    }


    /**
     * OVERWRITTEN: Because library can't parse body properly
     * Decode a stream of chat using the application/x-ndjson format
     */
    protected function decodeStreamOfChat(ResponseInterface $response): StreamInterface
    {
        return $response->getBody();
    }
}
