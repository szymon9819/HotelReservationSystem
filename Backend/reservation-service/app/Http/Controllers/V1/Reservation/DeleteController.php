<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResourceDeletedSuccessfullyResponse;
use App\Models\Reservation;
use Illuminate\Contracts\Support\Responsable;

final class DeleteController extends Controller
{
    public function __invoke(Reservation $reservation): Responsable
    {
        $reservation->delete();

        return new ApiResourceDeletedSuccessfullyResponse('Reservation');
    }
}
