<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Reservation\EditRequest;
use App\Http\Resources\V1\ReservationResource;
use App\Models\Reservation;
use Illuminate\Contracts\Support\Responsable;

final class EditController extends Controller
{
    public function __invoke(Reservation $reservation, EditRequest $request): Responsable
    {
        $reservation->update($request->all());

        return new ReservationResource($reservation);
    }
}
