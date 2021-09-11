<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class JoinEventService
{
    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        EventRepository $eventRepository,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ){
        $this->eventRepository = $eventRepository;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    public function joinEvent(int $id): bool
    {
        $event = $this->eventRepository->findEvent($id);
        if (\is_null($event)) {
            return false;
        }

        // Need to somehow get the user, Finding a random one ATM cuz theres no front app
        $user = $this->userRepository->findUserById(rand(1,49));
        $event->addParticipant($user);
        $this->entityManager->persist($event);
        $this->entityManager->flush();

        return true;
    }
}
