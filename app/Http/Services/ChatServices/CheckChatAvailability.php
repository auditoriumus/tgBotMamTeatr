<?php

namespace App\Http\Services\ChatServices;

class CheckChatAvailability extends BaseChatService
{
    public function checkChat($chatId)
    {
        return $this->chatRepository->checkChat($chatId);
    }
}
