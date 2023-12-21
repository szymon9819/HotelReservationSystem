<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api\V1\Reservation;

use App\Models\Reservation;
use Tests\Feature\TestCase;

class EditControllerTest extends TestCase
{
    public function test_edit_returns_single_reservation(): void
    {
        $reservation = Reservation::factory()->create();
        $newData = [
            'customer_id' => $reservation->customer_id,
            'room_id' => $reservation->room_id,
            'start_date' => $reservation->start_date,
            'end_date' => $reservation->end_date,
        ];

        $response = $this->put(route('api.v1.reservations.update', [
            'reservation' => $reservation,
            ...$newData,
        ]));

        $response->assertOk();
    }

    public function test_edit_returns_404_for_non_existing_reservation(): void
    {
        $nonExistingReservationId = 100;

        $response = $this->put(route('api.v1.reservations.update', [
            'reservation' => $nonExistingReservationId
        ]));

        $response->assertNotFound();
    }
}
