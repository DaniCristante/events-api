<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class JoinEventService
{
    /** @var EventRepository */
    private $eventRepository;

    /** @var UserRepository */
    private $userRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        EventRepository $eventRepository,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->eventRepository = $eventRepository;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    // TODO: Improve return so user can differenciate between errors (event full, bad request...)
    public function joinEvent(int $eventId, int $userId): bool
    {
        $event = $this->eventRepository->findEvent($eventId);
        if (null === $event) {
            return false;
        } elseif ($event->getCurrentEntries() >= $event->getMaxEntries()){
            return false;
        }

        // improvement on finding user by not sending it via url parameter?
        $user = $this->userRepository->findUserById($userId);
        $event->addParticipant($user);
        $this->entityManager->persist($event);
        $this->entityManager->flush();

        return true;
    }

    // TODO: verify that owner can't leave.
    public function leaveEvent(int $eventId, int $userId): bool
    {
        $event = $this->eventRepository->findEvent($eventId);

        if (is_null($event)) {
            return false;
        }

        $user = $this->userRepository->findUserById($userId);
        $event->removeParticipant($user);
        $this->entityManager->persist($event);
        $this->entityManager->flush();

        return true;
    }
}
