<?php

namespace App\Http\Services\NotificationsService;

use App\Http\Services\ChatServices\GetChatService;
use App\Http\Services\EventServices\GetEventsService;
use App\Http\Services\EventServices\UpdateEventService;
use App\Http\Services\TelegramInitService\TelegramInitService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

class NotificationsService
{
    public function __invoke()
    {
        Log::alert('start');
        $telegram = app(TelegramInitService::class)->telegram;
        $chatIdListArray = app(GetChatService::class)->getChatIdList();
        $eventsListArray = app(GetEventsService::class)->getActiveEvents();
        $current = Carbon::now();

        foreach ($eventsListArray as $eventArray) {

            $eventUuid = $eventArray['uuid'];
            $eventTitle = $eventArray['title'];
            $eventDescription = $eventArray['description'];

            //Дата и время события
            $eventDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $eventArray['date'] . ' ' . $eventArray['time']);

            //Разница между временем события и настоящим временем в днях
            $diffDays = $current->diffInDays($eventDateTime, false);

            //Разница между временем события и настоящим временем в часах
            $diffHours = $current->diffInHours($eventDateTime, false);

            //Разница между временем события и настоящим временем в минутах
            $diffMinutes = $current->diffInMinutes($eventDateTime, false);

            if ($current->format('Y-m-d') == $eventDateTime->format('Y-m-d')) {
                if ($current->greaterThan($eventDateTime->format('Y-m-d') . ' 21:14:00') && $current->lessThan($eventDateTime->format('Y-m-d') . ' 21:15:00')) {
                    $text = 'Привет! Напоминаем, что сегодня ' . "<b>$eventTitle</b>" . ' в ' . "<b>$eventDateTime->format('H:i')</b>" . '. Он состоится в уютном формате – встрече в zoom! Ссылку для входа пришлем за час и 5 минут до начала. Убедитесь, что у вас установлена программа. Вас уже зарегистрировалось более 400 человек! Мы этому рады! Следите за нашими письмами :)';
                    foreach ($chatIdListArray as $chatIdArray) {
                        try {
                            $response = $telegram->sendMessage([
                                'chat_id' => $chatIdArray['chat_id'],
                                'text' => $text,
                                'parse_mode' => 'HTML'
                            ]);
                        } catch (Exception $e) {
                            Log::info($e->getMessage());
                        }
                    }
                } elseif ($diffMinutes == 60) {
                    $text = 'Привет! Через час встречаемся в зуме на бесплатном мастер-классе. Готовьтесь к насыщенному и глубокому процессу, так что хорошо подкрепиться будет не лишним.';
                    foreach ($chatIdListArray as $chatIdArray) {
                        try {
                            $response = $telegram->sendMessage([
                                'chat_id' => $chatIdArray['chat_id'],
                                'text' => $text,
                                'parse_mode' => 'HTML'
                            ]);
                        } catch (Exception $e) {
                            Log::info($e->getMessage());
                        }
                    }
                } elseif ($diffMinutes == 4) {
                    $text = 'Через 5 минут выходим в эфир! Будет тепло☀️';
                    foreach ($chatIdListArray as $chatIdArray) {
                        try {
                            $response = $telegram->sendMessage([
                                'chat_id' => $chatIdArray['chat_id'],
                                'text' => $text,
                                'parse_mode' => 'HTML'
                            ]);
                        } catch (Exception $e) {
                            Log::info($e->getMessage());
                        }
                    }
                } elseif ($diffMinutes == 0) {
                    $text = 'Мы начинаем! Скорее хочется рассказать, зачем и как делать спектакли дома!️';
                    foreach ($chatIdListArray as $chatIdArray) {
                        try {
                            $response = $telegram->sendMessage([
                                'chat_id' => $chatIdArray['chat_id'],
                                'text' => $text,
                                'parse_mode' => 'HTML'
                            ]);
                        } catch (Exception $e) {
                            Log::info($e->getMessage());
                        }
                    }
                    app(UpdateEventService::class)->updateStatus($eventUuid);
                    Log::debug('Event ' . $eventUuid . ' is deactivated');
                }
            }

            Log::debug('Current time: ' . $current->format('H:i'));
            Log::debug('Current date: ' . $current);
            Log::debug('Event DateTime: ' . $eventDateTime);
            Log::debug('Diff in hours: ' . $diffHours);
            Log::debug('Diff in minutes: ' . $diffMinutes);
            Log::debug('Diff in days: ' . $diffDays);
            Log::info("\n");
        }
        Log::info("============\n\n");
    }
}

