<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Hotel;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\HotelResource;
use App\Models\Hotel;
use Illuminate\Contracts\Support\Responsable;

final class ShowController extends Controller
{
    public function __invoke($id): Responsable
    {
        return new HotelResource(Hotel::findOrFail($id));
    }
}
