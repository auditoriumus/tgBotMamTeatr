<?php

namespace App\Http\Services\TelegramInitService;

use Telegram\Bot\Api;

class TelegramInitService
{
    public $telegram;

    public function __construct()
    {
        $this->telegram = new Api(env('TG_TOKEN'));
    }
}
