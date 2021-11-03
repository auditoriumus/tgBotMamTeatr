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

//        $text = 'Театр – это не только что-то большое, торжественно-пышное и неуемно-жизнерадостное, как уже убедились многие мамы в Мамтеатре. Театр пронизывает нашу жизнь, и только нам решать, кто мы в этой ситуации – безвольные марионетки или творцы, режиссеры собственного счастья. ' . "\n\n"
//            . 'Так считает Екатерина Гороховская, режиссёр множественных постановок по всей России' . "\n" . 'Согласны? Тогда до скорой встречи!' . "\n\n"
//            . 'Поставь напоминание, чтобы не пропустить! ' . "\n" . '🕕 3 ноября в 18.00 по Москве';

        $text = 'Привет! Напоминаем, что сегодня ' . "<b>мастер-класс «Театр дома: с детьми и для детей»</b>" . ' в ' . '<b>18:00</b>' . '. Он состоится в уютном формате – встрече в zoom!' . "\n\n" . 'Ссылку для входа пришлем за час и 5 минут до начала. Убедитесь, что у вас установлена программа.' . "\n\n" . 'Вас уже зарегистрировалось более 300 человек! Мы этому рады! Следите за нашими письмами :)';


        foreach ($chatIdListArray as $chatIdArray) {
            Log::info('Готов чат: ' . $chatIdArray['chat_id']);
            try {
                $responsePhoto = $telegram->sendPhoto([
                    'photo' => 'AgACAgIAAxkBAAIRYGGCNjTJ3fcaZ6n1LghE5lyPnULcAAKNtjEbJlURSMgVR0686mzbAQADAgADcwADIQQ',
                    'chat_id' => $chatIdArray['chat_id'],
                ]);
                $responseText = $telegram->sendMessage([
                    'chat_id' => $chatIdArray['chat_id'],
                    'text' => $text,
                    'parse_mode' => 'HTML'
                ]);
                Log::info('Сообщение отправлено в чат: ' . $chatIdArray['chat_id']);
            } catch (Exception $e) {
                Log::alert('Сообщение не отправлено в чат: ' . $chatIdArray['chat_id']);
                Log::info($e->getMessage());
                continue;
            }
            sleep(5);
        }
        Log::info('Отправка закончена');
    }
}
