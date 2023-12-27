<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\RoomCart;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RoomCart\RemoveItem;
use App\Services\RoomCart\RoomCartServiceInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class RemoveFromCartController extends Controller
{
    public function __construct(
        private readonly RoomCartServiceInterface $roomCartService
    ) {
    }

    public function __invoke(RemoveItem $request): JsonResponse
    {
        $this->roomCartService->removeFromCart($request->getCustomerId(), $request->getRoomId());

        return new JsonResponse(
            $this->roomCartService->getCartEntity(
                $request->getCustomerId()
            ),
            Response::HTTP_NO_CONTENT
        );
    }
}
