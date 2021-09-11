<?php

namespace App\Controller;

use App\Service\JoinEventService;

class JoinEventController
{
    private $service;

    public function __construct(JoinEventService $service)
    {
        $this->service = $service;
    }

    public function join(string $id)
    {
        dump($id);
        $success = $this->service->joinEvent($id);
    }

    public function leave(string $id)
    {

    }
}
