<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonResponseService
{
    public function success(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'ok',
        ], Response::HTTP_OK);
    }

    public function error(array $status, $response = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return new JsonResponse([
            $status
        ], $response);
    }
}
