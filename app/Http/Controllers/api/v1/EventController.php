<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Services\EventServices\AddEventService;
use Illuminate\Http\Request;

class EventController
{
    public function store(Request $request)
    {
        $uuid = app(AddEventService::class)->addNew($request);
        if ($uuid) {
            return response()->json(['message' => 'Event has been added', 'id' => $uuid], 201);
        }
        return response()->json(['message' => 'Событие отклонено']);
    }
}
