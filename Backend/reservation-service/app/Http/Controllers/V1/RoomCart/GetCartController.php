<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\RoomCart;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RoomCart\ShowCart;
use App\Services\RoomCart\RoomCartServiceInterface;
use Illuminate\Http\JsonResponse;

final class GetCartController extends Controller
{
    public function __construct(
        private readonly RoomCartServiceInterface $roomCartService
    ) {
    }

    public function __invoke(ShowCart $request): JsonResponse
    {
        $cartEntity = $this->roomCartService->getCartEntity($request->getCustomerId());

        return new JsonResponse($cartEntity);
    }
}
