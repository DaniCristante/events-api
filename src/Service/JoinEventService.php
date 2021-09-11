<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\EventRepository;

class JoinEventService
{
    /**
     * @var EventRepository
     */
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function joinEvent(int $id): bool
    {
        $event = $this->eventRepository->findEvent($id);

        // Need to somehow get the user
        dump($event);
        if (null === $event) {
            return false;
        }

        return true;
    }
}
