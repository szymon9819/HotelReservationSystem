<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

use Symfony\Component\HttpFoundation\Response;

final readonly class ApiErrorResponse implements Responsable
{
    public function __construct(
        private string $title,
        private string $description,
        private int $status = Response::HTTP_INTERNAL_SERVER_ERROR
    ) {
    }

    public function toResponse($request): Response
    {
        return new JsonResponse(['title' => $this->title, 'description' => $this->description, 'status' => $this->status,], $this->status, );
    }
}
