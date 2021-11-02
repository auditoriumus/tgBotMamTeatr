<?php

namespace App\Http\Services\NotificationsService;

use App\Http\Services\ChatServices\GetChatService;
use App\Http\Services\TelegramInitService\TelegramInitService;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

class SendNotificatiosService
{
    public function sendNow()
    {
        $telegram = app(TelegramInitService::class)->telegram;
        $chatIdListArray = app(GetChatService::class)->getChatIdList();
        if (empty($chatIdListArray)) {
            Log::info('No chats');
            return;
        }

        foreach ($chatIdListArray as $chatIdArray) {
            $text = 'Театр – это не только что-то большое, торжественно-пышное и неуемно-жизнерадостное, как уже убедились многие мамы в Мамтеатре. Театр пронизывает нашу жизнь, и только нам решать, кто мы в этой ситуации – безвольные марионетки или творцы, режиссеры собственного счастья. ' . "\n\n"
                . 'Так считает Екатерина Гороховская, режиссёр множественных постановок по всей России' . "\n" . 'Согласны? Тогда до скорой встречи!' . "\n\n"
                . 'Поставь напоминание, чтобы не пропустить! ' . "\n" . '🕕 3 ноября в 18.00 по Москве';
            foreach ($chatIdListArray as $chatIdArray) {
                try {
                    $responsePhoto = $telegram->sendPhoto([
                        'photo' => 'AgACAgIAAxkBAAIJ02GBWYXTpQ0Hzbg92VIi4vwS1rumAAKotTEbYT4JSCI_4HA_fflUAQADAgADcwADIQQ',
                        'chat_id' => $chatIdArray['chat_id'],
                    ]);
                    $responseText = $telegram->sendMessage([
                        'chat_id' => $chatIdArray['chat_id'],
                        'text' => $text,
                        'parse_mode' => 'HTML'
                    ]);
                } catch (Exception $e) {
                    Log::info($e->getMessage());
                    return;
                }
            }
        }
    }
}
