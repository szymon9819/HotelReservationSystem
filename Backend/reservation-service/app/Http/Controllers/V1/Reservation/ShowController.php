<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ReservationResource;
use App\Models\Reservation;
use Illuminate\Contracts\Support\Responsable;

final class ShowController extends Controller
{
    public function __invoke(Reservation $reservation): Responsable
    {
        return new ReservationResource($reservation);
    }
}
