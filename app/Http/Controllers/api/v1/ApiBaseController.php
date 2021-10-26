<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Services\TelegramInitService\TelegramInitService;
use Illuminate\Http\Request;

class ApiBaseController extends Controller
{
    protected $telegram;
    protected $chatId;
    protected $message;

    public function __construct(Request $request)
    {
        $this->telegram = app(TelegramInitService::class)->telegram;
        $this->chatId = $request->input('message')['chat']['id'] ?? '';
        $this->message = $request->input('message')['text'] ?? '';
    }
}
