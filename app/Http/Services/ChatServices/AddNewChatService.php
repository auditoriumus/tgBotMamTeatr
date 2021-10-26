<?php

namespace App\Http\Services\ChatServices;

class AddNewChatService extends BaseChatService
{
    public function addNew($chatId)
    {
        return $this->chatRepository->addNew($chatId);
    }
}
