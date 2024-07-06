<?php

namespace App\Domains\AI\Http\Controllers;

use App\Domains\AI\Data\ChatMessageData;
use App\Domains\AI\Http\Requests\ChatMessageRequest;
use App\Domains\AI\Services\ChatService;
use App\Domains\User\Models\User;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;

class ChatController
{
    use ApiResponseHelpers;

    public function __construct(protected ChatService $chatService)
    {
    }

    public function index(): JsonResponse
    {
        return $this->respondWithSuccess(ChatMessageData::collect(
            $this->chatService->history(User::query()->first())
        ));
    }

    public function send(ChatMessageRequest $request): JsonResponse
    {
        return $this->respondWithSuccess(
            $this->chatService->send(User::query()->first(), $request->message())->toArray()
        );
    }
}
