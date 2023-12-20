<?php

declare(strict_types=1);

namespace Feature\Controllers\Api\V1\Hotel;

use App\Models\Hotel;
use Tests\Feature\TestCase;

class DeleteControllerTest extends TestCase
{
    public function test_delete_removes_hotel_from_database(): void
    {
        $hotel = Hotel::factory()->create();

        $response = $this->delete(route('api.v1.hotels.destroy', [
            'hotel' => $hotel
        ]));

        $response->assertOk();
        $this->assertDatabaseMissing('hotels', ['id' => $hotel->id]);
    }

    public function test_delete_returns_404_for_non_existing_hotel(): void
    {
        $nonExistingHotelId = 100;

        $response = $this->delete(route('api.v1.hotels.destroy', [
            'hotel' => $nonExistingHotelId
        ]));

        $response->assertNotFound();
    }
}
