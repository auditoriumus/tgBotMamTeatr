<?php

namespace App\Http\Repositories\ChatRepository;

use App\Http\Repositories\Repository;
use App\Models\Chat;

class ChatRepository extends Repository
{
    public function __construct(Chat $model)
    {
        parent::__construct($model);
    }

    public function checkChat($chatId)
    {
        return $this->model->where('chat_id', $chatId)->first();
    }

    public function addNew($chatId)
    {
        $this->model->chat_id = $chatId;
        return $this->model->save();
    }

    public function getChatIdList()
    {
        return $this->model
            ->select('chat_id')
            ->get();
    }
}
