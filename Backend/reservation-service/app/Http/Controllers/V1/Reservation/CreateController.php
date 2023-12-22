<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Reservation\CreateRequest;
use App\Services\Reservation\ReservationService;
use App\Services\RoomCart\RoomCartServiceInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class CreateController extends Controller
{
    public function __construct(
        private readonly RoomCartServiceInterface $cartService,
        private readonly ReservationService $reservationService
    ) {
    }

    public function __invoke(CreateRequest $request): JsonResponse
    {
        if (!$this->cartService->hasSelectedRooms($request->getCustomerId())) {
            return new JsonResponse([
                'message' => __('response_messages.cart.empty'),
            ], Response::HTTP_ACCEPTED);
        }

        try {
            $this->reservationService->createReservationsByContract($request);

            return new JsonResponse([
                'message' => __('response_messages.reservation.created_successfully'),
            ], Response::HTTP_CREATED);
        } catch (Throwable) {
            return new JsonResponse([
                'message' => __('response_messages.reservation.creation_failed'),
            ], Response::HTTP_CONFLICT);
        }
    }
}
