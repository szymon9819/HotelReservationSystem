<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Hotel;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\HotelResource;
use App\Models\Hotel;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;

final class EditController extends Controller
{
    public function __invoke(Hotel $hotel, Request $request): Responsable
    {
        $hotel = Hotel::findOrFail($hotel->getId());
        $hotel->update($request->all());

        return new HotelResource($hotel);
    }
}
