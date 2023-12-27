<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\RoomCart;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RoomCart\AddRoom;
use App\Services\RoomCart\RoomCartServiceInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class AddToCartController extends Controller
{
    public function __construct(
        private readonly RoomCartServiceInterface $roomCartService
    ) {
    }

    public function __invoke(AddRoom $request): JsonResponse
    {
        try {
            $this->roomCartService->addToCart($request->getCustomerId(), $request->getRoomId());

            return new JsonResponse([
                'message' => __('response_messages.room.added_to_cart'),
            ], Response::HTTP_CREATED);
        } catch (Throwable) {
            return new JsonResponse([
                'message' => __('response_messages.room.locked'),
            ], Response::HTTP_CONFLICT);
        }
    }
}
