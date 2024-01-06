<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

class RoomResource extends JsonResource
{
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'hotel' => new HotelResource($this->whenLoaded('hotel')),
            'room_type' => $this->room_type,
            'price_per_night' => $this->price_per_night,
            'availability' => $this->availability,
            'description' => $this->description,
        ];
    }
}
