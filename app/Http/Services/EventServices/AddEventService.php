<?php

namespace App\Http\Services\EventServices;


use Faker\Provider\Uuid;
use Illuminate\Http\Request;

class AddEventService extends BaseEventService
{
    public function addNew(Request $request)
    {
        $data = [];
        if ($request->has([
            'title',
            'description',
            'date',
            'time',
        ])) {
            $uuid = Uuid::uuid();
            $data['title'] = $request->input('title');
            $data['description'] = $request->input('description');
            $data['date'] = $request->input('date');
            $data['time'] = $request->input('time');
            $data['uuid'] = $uuid;
            if ($this->eventRepository->addNew($data)) {
                return $uuid;
            }
            return false;
        } else {
            return response()->json(['message' => 'Все поля обязательны для заполнения']);
        }
    }
}
