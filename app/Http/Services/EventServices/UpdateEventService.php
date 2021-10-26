<?php

namespace App\Http\Services\EventServices;

class UpdateEventService extends BaseEventService
{
    public function updateStatus(string $uuid)
    {
        return $this->eventRepository->deactivateByUuid($uuid);
    }
}
