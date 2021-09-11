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

    public function join(int $id): JsonResponse
    {
        $success = $this->service->joinEvent($id);

        if (!$success) {
            return $this->jsonResponseService->error();
        }

        return $this->jsonResponseService->success();
    }

    public function leave(int $id): JsonResponse
    {
        $success = true;

        if (!$success) {
            return $this->jsonResponseService->error();
        }

        return $this->jsonResponseService->success();
    }
}
