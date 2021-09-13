<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JoinEventService
{
    /** @var EventRepository */
    private $eventRepository;

    /** @var UserRepository */
    private $userRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var JsonResponseService */
    private $jsonResponseService;

    public function __construct(
        EventRepository $eventRepository,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        JsonResponseService $jsonResponseService
    ) {
        $this->eventRepository = $eventRepository;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->jsonResponseService = $jsonResponseService;
    }

    public function joinEvent(int $eventId, int $userId): JsonResponse
    {
        $event = $this->eventRepository->findEvent($eventId);
        if (null === $event) {
            return $this->jsonResponseService->error([
                'status' => 'not_found'
            ], Response::HTTP_NOT_FOUND);
        } elseif ($event->getCurrentEntries() >= $event->getMaxEntries()) {
            return $this->jsonResponseService->error([
                'status' => 'event_full'
            ], Response::HTTP_FORBIDDEN);
        }

        // improvement on finding user by not sending it via url parameter?
        $user = $this->userRepository->findUserById($userId);
        $event->addParticipant($user);
        $this->entityManager->persist($event);
        $this->entityManager->flush();

        return $this->jsonResponseService->success();
    }

    // TODO: verify that owner can't leave.
    public function leaveEvent(int $eventId, int $userId): JsonResponse
    {
        $event = $this->eventRepository->findEvent($eventId);

        if (null === $event) {
            return $this->jsonResponseService->error([
                'status' => 'not_found'
            ], Response::HTTP_NOT_FOUND);
        }

        $user = $this->userRepository->findUserById($userId);
        $event->removeParticipant($user);
        $this->entityManager->persist($event);
        $this->entityManager->flush();

        $this->jsonResponseService->success();
    }
}
