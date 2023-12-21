<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Hotel;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Hotel\EditRequest;
use App\Http\Resources\V1\HotelResource;
use App\Models\Hotel;
use Illuminate\Contracts\Support\Responsable;

final class EditController extends Controller
{
    public function __invoke(Hotel $hotel, EditRequest $request): Responsable
    {
        $hotel->update($request->all());

        return new HotelResource($hotel);
    }
}
