<?php

namespace App\Http\Services\ChatServices;

class GetChatService extends BaseChatService
{
    public function getChatIdList()
    {
        return $this->chatRepository
            ->getChatIdList()
            ->toArray();
    }
}
