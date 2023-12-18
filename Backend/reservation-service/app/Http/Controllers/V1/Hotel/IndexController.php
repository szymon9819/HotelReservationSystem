<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Hotel;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\HotelResource;
use App\Models\Hotel;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;

final class IndexController extends Controller
{
    public function __invoke(Request $request): Responsable
    {
        return HotelResource::collection(Hotel::all());
    }
}
