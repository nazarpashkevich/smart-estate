<?php

namespace App\Domains\AI\Http\Controllers;

use App\Domains\AI\Data\ChatMessageData;
use App\Domains\AI\Http\Requests\ChatMessageRequest;
use App\Domains\AI\Services\ChatService;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ChatController
{
    use ApiResponseHelpers;

    public function __construct(protected ChatService $chatService)
    {
    }

    public function index(): JsonResponse
    {
        return $this->respondWithSuccess(ChatMessageData::collect(
            $this->chatService->history(Auth::user())
        ));
    }

    /**
     * @throws \App\Domains\AI\Exceptions\GeneratingAIResponseError
     */
    public function send(ChatMessageRequest $request): StreamedResponse
    {
        return $this->chatService->sendStreamed(Auth::user(), $request->message());
    }
}
