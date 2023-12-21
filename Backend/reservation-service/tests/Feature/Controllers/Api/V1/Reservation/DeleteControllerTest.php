<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api\V1\Reservation;

use App\Models\Reservation;
use Tests\Feature\TestCase;

class DeleteControllerTest extends TestCase
{
    public function test_delete_removes_reservation_from_database(): void
    {
        $reservation = Reservation::factory()->create();

        $response = $this->delete(route('api.v1.reservations.destroy', [
            'reservation' => $reservation
        ]));

        $response->assertOk();
        $this->assertDatabaseMissing('reservations', ['id' => $reservation->id]);
    }

    public function test_delete_returns_404_for_non_existing_reservation(): void
    {
        $nonExistingReservationId = 100;

        $response = $this->delete(route('api.v1.reservations.destroy', [
            'reservation' => $nonExistingReservationId
        ]));

        $response->assertNotFound();
    }
}
