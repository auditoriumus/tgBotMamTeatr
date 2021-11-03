<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Services\ChatServices\AddNewChatService;
use App\Http\Services\ChatServices\CheckChatAvailability;
use App\Http\Services\ChatServices\GetChatsCountService;
use App\Models\Chat;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Log;

class BotController extends ApiBaseController
{
    public function handle()
    {
        Log::alert('Пользователь вошел: ' . $this->chatId);
        if ($this->message == '/start') {
            if (!app(CheckChatAvailability::class)->checkChat($this->chatId)) {
                app(AddNewChatService::class)->addNew($this->chatId);
            }
            $text = 'Вебинар уже стартовал, скорее присоединяйся!' . "\n\n"
                . 'Ссылка: <a href="https://igoe.ru/mt/zoom/">https://igoe.ru/mt/zoom/</a>';
            try {
                $responseText = $this->telegram->sendMessage([
                    'chat_id' => $this->chatId,
                    'text' => $text,
                    'parse_mode' => 'HTML'
                ]);
            } catch (\Exception $e) {
                \Log::alert($e->getMessage());
                return;
            }

//            $menu = [
//                [
//                    ['text' => 'Смотреть запись', 'url' => 'https://ya.ru']
//                ]
//            ];
//
//            $this->telegram->sendMessage([
//                'chat_id' => $this->chatId,
//                'text' => '🟡 Запись вебинара 🟡' . "\n\n" . 'Доступна 24 часа!',
//                'reply_markup' => json_encode(['inline_keyboard' => $menu])
//            ]);


//            sleep(30);
//
//            $text2 = 'Живой мастер-класс «Театр дома: с детьми и для детей» состоится в доверительной встрече в зум!  Так мы будем ближе друг к другу☺️' . "\n\n"
//                . 'Перед началом скачайте программу Zoom она БЕСПЛАТНАЯ ' . "\n\n"
//                . '▶️Ссылки для установки на планшет или телефон: ' . "\n\n"
//                . '<a href="https://play.google.com/store/apps/details?id=us.zoom.videomeetings&hl=ru">https://play.google.com/store/apps/details?id=us.zoom.videomeetings&hl=ru</a>' . "\n\n"
//                . '▶️Если у вас iPhone '  . "\n\n"
//                . '<a href="https://apps.apple.com/ru/app/zoom-cloud-meetings/id546505307">https://apps.apple.com/ru/app/zoom-cloud-meetings/id546505307</a>';
//            try {
//                $responseText = $this->telegram->sendMessage([
//                    'chat_id' => $this->chatId,
//                    'text' => $text2,
//                    'parse_mode' => 'HTML'
//                ]);
//            } catch (\Exception $e) {
//                \Log::alert($e->getMessage());
//                return;
//            }
        } elseif ($this->message == '/getcount') {
            $count = app(GetChatsCountService::class)->getCount();
            if (empty($count)) {
                return;
            }
            try {
                $responseText = $this->telegram->sendMessage([
                    'chat_id' => $this->chatId,
                    'text' => $count,
                    'parse_mode' => 'HTML'
                ]);
            } catch (\Exception $e) {
                \Log::alert($e->getMessage());
                return;
            }
        } elseif (mb_strtolower($this->message) == 'тепло') {
            if ($this->chatId == 738833121) {
                $this->telegram->sendDocument([
                    'chat_id' => $this->chatId,
                    'document' => 'BQACAgIAAxkBAANKYYLTVxWSgac_A_XWXrPpCNrxksEAAosTAAIwHRlIYofL78FcAnYhBA',
                ]);
            }
        }
    }
}

