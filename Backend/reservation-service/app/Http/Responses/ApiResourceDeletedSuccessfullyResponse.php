<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

use Symfony\Component\HttpFoundation\Response;

final readonly class ApiResourceDeletedSuccessfullyResponse implements Responsable
{
    public function __construct(
        private string $resourceName,
        private int $status = Response::HTTP_OK
    ) {
    }

    public function toResponse($request): Response
    {
        return new JsonResponse(
            [
                'message' => __('deleted_successfully', [
                    'resource_name' => $this->resourceName,
                ]),
                'status' => $this->status,
            ],
            $this->status,
        );
    }
}
