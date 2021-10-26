<?php

namespace App\Http\Services\ChatServices;

use App\Http\Repositories\ChatRepository\ChatRepository;
use App\Http\Services\Service;

class BaseChatService extends Service
{
    protected $chatRepository;
    public function __construct(ChatRepository $chatRepository)
    {
        $this->chatRepository = $chatRepository;
    }
}
