<?php

namespace App\Http\Services\EventServices;

class GetEventsService extends BaseEventService
{
    public function getActiveEvents()
    {
        return $this->eventRepository->getActive()
            ->toArray();
    }
}
