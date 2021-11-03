<?php

namespace App\Http\Services\NotificationsService;

use App\Http\Services\ChatServices\GetChatService;
use App\Http\Services\EventServices\GetEventsService;
use App\Http\Services\EventServices\UpdateEventService;
use App\Http\Services\TelegramInitService\TelegramInitService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;
use Telegram\Bot\Exceptions\TelegramResponseException;

class NotificationsService
{
    public function __invoke()
    {
        Log::alert('start');
        $telegram = app(TelegramInitService::class)->telegram;
        $chatIdListArray = app(GetChatService::class)->getChatIdList();
        if (empty($chatIdListArray)) {
            Log::info('No chats');
            return;
        }
        $eventsListArray = app(GetEventsService::class)->getActiveEvents();
        $current = Carbon::now();

        foreach ($eventsListArray as $eventArray) {

            //Log::info($eventArray);
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

//            Log::info($current->format('Y-m-d'));
//            Log::info($eventDateTime->format('Y-m-d'));
//            Log::info($current->format('Y-m-d') == $eventDateTime->format('Y-m-d'));
            Log::info($diffMinutes);
            if ($current->format('Y-m-d') == $eventDateTime->format('Y-m-d')) {
                if ($current->greaterThan($eventDateTime->format('Y-m-d') . ' 15:30:00') && $current->lessThan($eventDateTime->format('Y-m-d') . ' 15:31:00')) {
                    $text = 'Привет! Напоминаем, что сегодня ' . "<b>$eventTitle</b>" . ' в ' . '<b>' . $eventDateTime->format('H:i') . '</b>' . '. Он состоится в уютном формате – встрече в zoom! Ссылку для входа пришлем за час и 5 минут до начала. Убедитесь, что у вас установлена программа. Вас уже зарегистрировалось более 500 человек! Мы этому рады! Следите за нашими письмами :)';

                    foreach ($chatIdListArray as $chatIdArray) {
                        Log::info('Пользователь ' . $chatIdArray['chat_id'] . ' готов');
                        try {
                            $telegram->sendPhoto([
                                'photo' => 'AgACAgIAAxkBAAIBpmF9GEMtd5JjwJ7yM-ArrKlvA2lQAALUtDEbg7PpSwnXFUE_lkoKAQADAgADcwADIQQ',
                                'chat_id' => $chatIdArray['chat_id'],
                            ]);
                            $telegram->sendMessage([
                                'chat_id' => $chatIdArray['chat_id'],
                                'text' => $text,
                                'parse_mode' => 'HTML'
                            ]);
                            Log::info('Пользователь ' . $chatIdArray['chat_id'] . ' получил сообщение');
                        } catch (\Exception $e) {
                            Log::info($e->getMessage());
                        }
                        sleep(1);
                    }
                } elseif ($current->greaterThan($eventDateTime->format('Y-m-d') . ' 16:55:00') && $current->lessThan($eventDateTime->format('Y-m-d') . ' 16:56:00')) {
                    $text = 'Привет!' . "\n"
                        . 'Через час встречаемся в зуме на бесплатном мастер-классе. '. "\n\n"
                        . 'Готовьтесь к глубокому процессу. Мы не будем учить вас как развлекать детей, мы будем говорить о том, как чувства выразить не только словом.' . "\n"
                        . 'И театр в этом нам поможет!' . "\n\n"
                        . '🟣 Ссылка для входа на мастер-класс: ' . '<a href="https://igoe.ru/mt/zoom/">https://igoe.ru/mt/zoom/</a>';

                    foreach ($chatIdListArray as $chatIdArray) {
                        Log::info('Пользователь ' . $chatIdArray['chat_id'] . ' готов');
                        try {
                            $telegram->sendPhoto([
                                'photo' => 'AgACAgIAAxkBAAIWgmGCe1CEEblJp5onyzYdy5klu3XyAAICtzEbJlURSLr7bIOGbQABRAEAAwIAA3MAAyEE',
                                'chat_id' => $chatIdArray['chat_id'],
                            ]);
                            $telegram->sendMessage([
                                'chat_id' => $chatIdArray['chat_id'],
                                'text' => $text,
                                'parse_mode' => 'HTML'
                            ]);
                            Log::info('Пользователь ' . $chatIdArray['chat_id'] . ' получил сообщение');
                        } catch (\Exception $e) {
                            Log::info($e->getMessage());
                        }
                        sleep(1);
                    }
                } elseif ($diffMinutes == 6) {
                    $text = 'Через 5 минут, <b>ровно в 18:00</b>, выходим в эфир! Узнаете секреты создания домашних спектаклей!' . "\n\n"
                        . 'Будет тепло☀️' . "\n\n"
                        . 'Ссылка: <a href="https://igoe.ru/mt/zoom/">https://igoe.ru/mt/zoom/</a>';
                    foreach ($chatIdListArray as $chatIdArray) {
                        try {
                            $response = $telegram->sendMessage([
                                'chat_id' => $chatIdArray['chat_id'],
                                'text' => $text,
                                'parse_mode' => 'HTML'
                            ]);
                        } catch (\Exception $e) {
                            Log::info($e->getMessage());
                        }
                        usleep(50000);
                    }
                } elseif ($diffMinutes == 2) {
                    $text = 'Мы начинаем! Скорее хочется рассказать, зачем и как делать спектакли дома!️' . "\n\n"
                        . 'Ссылка: <a href="https://igoe.ru/mt/zoom/">https://igoe.ru/mt/zoom/</a>';
                    foreach ($chatIdListArray as $chatIdArray) {
                        try {
                            $response = $telegram->sendMessage([
                                'chat_id' => $chatIdArray['chat_id'],
                                'text' => $text,
                                'parse_mode' => 'HTML'
                            ]);
                        } catch (\Exception $e) {
                            Log::info($e->getMessage());
                        }
                        usleep(50000);
                    }
                    app(UpdateEventService::class)->updateStatus($eventUuid);
                    Log::debug('Event ' . $eventUuid . ' is deactivated');
                }
            }

//            Log::debug('Current time: ' . $current->format('H:i'));
//            Log::debug('Current date: ' . $current);
//            Log::debug('Event DateTime: ' . $eventDateTime);
//            Log::debug('Diff in hours: ' . $diffHours);
//            Log::debug('Diff in minutes: ' . $diffMinutes);
//            Log::debug('Diff in days: ' . $diffDays);
//            Log::info("\n");
        }
        //Log::info("============\n\n");
    }
}

