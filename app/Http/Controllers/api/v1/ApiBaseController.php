<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Services\PictureServices\AddNewPictureService;
use App\Http\Services\TelegramInitService\TelegramInitService;
use Illuminate\Http\Request;

class ApiBaseController extends Controller
{
    protected $telegram;
    protected $chatId;
    protected $message;
    protected $photo;

    public function __construct(Request $request)
    {
        $this->telegram = app(TelegramInitService::class)->telegram;
        $this->chatId = $request->input('message')['chat']['id'] ?? '';
        $this->message = $request->input('message')['text'] ?? '';
        $this->photo = $request->input('message')['photo'] ?? null;

        if (!empty($this->photo) && is_array($this->photo)) {
            $data = [];
            foreach ($this->photo as $key => $item) {
                $data[$key]['file_id'] = $item['file_id'];
                $data[$key]['file_unique_id'] = $item['file_unique_id'];
                $data[$key]['file_size'] = $item['file_size'];
                $data[$key]['width'] = $item['width'];
                $data[$key]['height'] = $item['height'];
            }
            try {
                app(AddNewPictureService::class)->addSeveralPictures($data);
            } catch (\Exception $e) {
                return;
            }
        }
    }
}
