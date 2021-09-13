<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\JoinEventService;
use App\Service\JsonResponseService;
use Symfony\Component\HttpFoundation\JsonResponse;

class JoinEventController
{
    /** @var JoinEventService */
    private $service;

    /** @var JsonResponseService */
    private $jsonResponseService;

    public function __construct(
        JoinEventService $service,
        JsonResponseService $jsonResponseService
    ) {
        $this->service = $service;
        $this->jsonResponseService = $jsonResponseService;
    }

    public function join(int $eventId, int $userId): JsonResponse
    {
        $response = $this->service->joinEvent($eventId, $userId);

        return $response;
    }

    public function leave(int $eventId, int $userId): JsonResponse
    {
        $response = $this->service->leaveEvent($eventId, $userId);

        return $response;
    }
}
