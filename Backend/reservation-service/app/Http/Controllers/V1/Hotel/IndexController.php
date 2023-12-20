<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Hotel;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Hotel\IndexRequest;
use App\Http\Resources\V1\HotelResource;
use App\Models\Hotel;
use Illuminate\Contracts\Support\Responsable;

final class IndexController extends Controller
{
    public function __invoke(IndexRequest $request): Responsable
    {
        $hotels = Hotel::query()->paginate(
            perPage: $request->getLimit(),
            page: $request->hasPage() ? $request->getPage() : null)
        ;

        return HotelResource::collection($hotels);
    }
}
