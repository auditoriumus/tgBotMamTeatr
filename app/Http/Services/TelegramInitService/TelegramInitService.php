<?php

namespace App\Http\Services\TelegramInitService;

use Telegram\Bot\Api;

class TelegramInitService
{
    public $telegram;

    public function __construct()
    {
        $this->telegram = new Api('2075110498:AAE7UM1OrBCE1ywD_dzegJkYYyp-KCDScYw');
    }
}
