<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\RoomCart;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RoomCart\ClearCart;
use App\Services\RoomCart\RoomCartServiceInterface;
use Illuminate\Http\JsonResponse;

final class ClearCartController extends Controller
{
    public function __construct(
        private readonly RoomCartServiceInterface $roomCartService
    ) {
    }

    public function __invoke(ClearCart $request): JsonResponse
    {
        $this->roomCartService->clearCart($request->getCustomerId());

        return new JsonResponse(
            $this->roomCartService->getCartEntity(
                $request->getCustomerId()
            )
        );
    }
}
