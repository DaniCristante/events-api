<?php

namespace App\Service;

use App\Repository\EventRepository;

class JoinEventService
{

    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function joinEvent(string $id): bool
    {
        $event = $this->eventRepository->findEvent($id);

        // Need to somehow get the user
        dump($event);
        if ($event === null) {
            return false;
        }

        return true;
    }
}
