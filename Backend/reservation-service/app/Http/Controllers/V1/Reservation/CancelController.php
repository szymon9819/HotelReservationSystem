<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Reservation;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Services\Reservation\ReservationService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CancelController extends Controller
{
    public function __construct(
        private readonly ReservationService $reservationService
    ) {
    }

    public function __invoke(Reservation $reservation): JsonResponse
    {
        $this->reservationService->cancel($reservation);

        return new JsonResponse([
            'message' => __('response_messages.reservation.cancelled'),
        ], Response::HTTP_NO_CONTENT);
    }
}
