<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\JoinEventService;
use Symfony\Component\HttpFoundation\Response;

class JoinEventController
{
    /**
     * @var JoinEventService
     */
    private $service;

    public function __construct(JoinEventService $service)
    {
        $this->service = $service;
    }

    public function join(int $id): Response
    {
        $success = $this->service->joinEvent($id);

        return new Response();
    }

    public function leave(int $id): Response
    {
        return new Response();
    }
}
