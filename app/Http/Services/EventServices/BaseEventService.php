<?php

namespace App\Http\Services\EventServices;

use App\Http\Repositories\EventRepository\EventRepository;
use App\Http\Services\Service;

class BaseEventService extends Service
{
    protected $eventRepository;
    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }
}
