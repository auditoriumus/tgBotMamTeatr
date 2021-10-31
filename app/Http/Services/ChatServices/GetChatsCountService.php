<?php

namespace App\Http\Services\ChatServices;

class GetChatsCountService extends BaseChatService
{
    public function getCount()
    {
        return $this->chatRepository->getCount();
    }
}
