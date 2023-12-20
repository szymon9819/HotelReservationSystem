<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Reservation\IndexRequest;
use App\Http\Resources\V1\ReservationResource;
use App\Models\Reservation;
use Illuminate\Contracts\Support\Responsable;

final class IndexController extends Controller
{
    public function __invoke(IndexRequest $request): Responsable
    {
        $reservations = Reservation::query()->paginate(
            perPage: $request->getLimit(),
            page: $request->hasPage() ? $request->getPage() : null
        );

        return ReservationResource::collection($reservations);
    }
}
