<?php

namespace Database\Seeders;

use Faker\Provider\Uuid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
           [
               'uuid' => Uuid::uuid(),
               'title' => 'мастер-класс «Театр дома: с детьми и для детей»',
               'description' => 'Впереди вас ждёт живой мастер-класс «Театр дома: с детьми и для детей» 3 ноября в 18:00 по Москве. Его проведет Екатерина Гороховская, актриса, театральный критик, режиссер. Вы и ваши дети уже знакомы с ней, ведь именно её голосом говорит Лунтик, Лиза Барбоскина и другие популярные мультперсонажи. Эфир пройдёт совместно с Жанной Мороз, продюсером культурных проектов и автором театральной школы для мам «Мамтеатр». Вы узнаете, как создать маленький домашний спектакль, как сделать невербальное вербальным, как определить тему и выбрать материал спектакля. На мастер-классе вы поймёте, можно ли стать режиссёром своей жизни, зачем ставить домашние спектакли и какие проблемы это помогает решить. О том, зачем театр и как он связан с нашей реальной жизнью. Здесь мы напомним о начале мастер-класса, чтобы вы его не пропустили. По ссылке подписывайтесь на канал – там будут единомышленники и полезная информация! <a href="https://t.me/mamteatr_canal">https://t.me/mamteatr_canal</a> Бот — для ссылок на вебинар, в канале — полезная информация. Мамтеатр в Инстаграме <a href="https://instagram.com/mamteatr">instagram.com/mamteatr</a>',
               "date" => "2021-10-25",
               "time" => "22:00"
           ]
        ];

        DB::table('events')->insert($data);
    }
}
