<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Services\ChatServices\AddNewChatService;
use App\Http\Services\ChatServices\CheckChatAvailability;
use App\Http\Services\ChatServices\GetChatsCountService;
use App\Models\Chat;

class BotController extends ApiBaseController
{
    public function handle()
    {
        if ($this->message == '/start') {
            if (!app(CheckChatAvailability::class)->checkChat($this->chatId)) {
                app(AddNewChatService::class)->addNew($this->chatId);
            }
            $text = 'Поздравляем!' . "\n" . 'Впереди вас ждёт живой мастер-класс «Театр дома: с детьми и для детей» 3 ноября в 18:00 по Москве.' . "\n"
                . 'Его проведет Екатерина Гороховская, актриса, театральный критик, режиссер. Вы и ваши дети уже знакомы с ней, ведь именно её голосом говорит Лунтик, Лиза Барбоскина и другие популярные мультперсонажи.' . "\n\n"
                . 'Эфир пройдёт совместно с Жанной Мороз, продюсером культурных проектов и автором театральной школы для мам «Мамтеатр».' . "\n\n"
                . 'Вы узнаете, как создать маленький домашний спектакль, как сделать невербальное вербальным, как определить тему и выбрать материал спектакля.' . "\n\n"
                . 'На мастер-классе вы поймёте, можно ли стать режиссёром своей жизни, зачем ставить домашние спектакли и какие проблемы это помогает решить. О том, зачем театр и как он связан с нашей реальной жизнью.' . "\n\n"
                . '🟣 Здесь мы напомним о начале мастер-класса, чтобы вы его не пропустили.' . "\n\n"
                . '🟣 По ссылке подписывайтесь на канал – там будут единомышленники и полезная информация!' . "\n\n"
                . '<a href="https://t.me/mamteatr_canal">https://t.me/mamteatr_canal</a>' . "\n\n"
                . 'Бот — для ссылок на вебинар, в канале — полезная информация.' . "\n\n"
                . '🟡 Мамтеатр в Инстаграме <a href="https://instagram.com/mamteatr">instagram.com/mamteatr</a>';
            try {
                $responsePhoto = $this->telegram->sendPhoto([
                    'photo' => 'AgACAgIAAxkBAAIBBGF7sXzIPnZiUuksOctsI1vxYWajAALytTEblwbgS3m2V4UwDveIAQADAgADcwADIQQ',
                    'chat_id' => $this->chatId,
                ]);
                $responseText = $this->telegram->sendMessage([
                    'chat_id' => $this->chatId,
                    'text' => $text,
                    'parse_mode' => 'HTML'
                ]);
            } catch (\Exception $e) {
                \Log::alert($e->getMessage());
                return;
            }

           // sleep(50);

            $text2 = 'Живой мастер-класс «Театр дома: с детьми и для детей» состоится в доверительной встрече в зум!  Так мы будем ближе друг к другу☺️' . "\n\n"
                . 'Перед началом скачайте программу Zoom она БЕСПЛАТНАЯ ' . "\n\n"
                . '▶️Ссылки для установки на планшет или телефон: ' . "\n\n"
                . '<a href="https://play.google.com/store/apps/details?id=us.zoom.videomeetings&hl=ru">https://play.google.com/store/apps/details?id=us.zoom.videomeetings&hl=ru</a>' . "\n\n"
                . '▶️Если у вас iPhone '  . "\n\n"
                . '<a href="https://apps.apple.com/ru/app/zoom-cloud-meetings/id546505307">https://apps.apple.com/ru/app/zoom-cloud-meetings/id546505307</a>';
            try {
                $responseText = $this->telegram->sendMessage([
                    'chat_id' => $this->chatId,
                    'text' => $text2,
                    'parse_mode' => 'HTML'
                ]);
            } catch (\Exception $e) {
                \Log::alert($e->getMessage());
                return;
            }
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
        }
    }
}

