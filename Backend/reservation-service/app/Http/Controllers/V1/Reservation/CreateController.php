<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Reservation\CreateRequest;
use App\Http\Resources\V1\ReservationResource;
use App\Models\Reservation;
use Illuminate\Contracts\Support\Responsable;

final class CreateController extends Controller
{
    public function __invoke(CreateRequest $request): Responsable
    {
        $reservation = Reservation::create($request->all());

        return new ReservationResource($reservation);
    }
}
