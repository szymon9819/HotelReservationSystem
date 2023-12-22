<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Reservation\IndexRequest;
use App\Http\Resources\V1\ReservationResource;
use App\Services\Reservation\ReservationService;
use Illuminate\Contracts\Support\Responsable;

final class IndexController extends Controller
{
    public function __construct(
        private readonly ReservationService $reservationService
    ) {
    }

    public function __invoke(IndexRequest $request): Responsable
    {
        $reservations = $this->reservationService->getPaginatedByContract($request, $request);

        return ReservationResource::collection($reservations);
    }
}
