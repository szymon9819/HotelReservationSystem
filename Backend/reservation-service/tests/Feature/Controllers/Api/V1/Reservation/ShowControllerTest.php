<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api\V1\Reservation;

use App\Models\Reservation;
use Tests\Feature\TestCase;

class ShowControllerTest extends TestCase
{
    public function test_show_returns_single_reservation(): void
    {
        $reservation = Reservation::factory()->create();

        $response = $this->get(route('api.v1.reservations.show', ['reservation' => $reservation]));

        $response->assertOk()->assertJsonFragment([
            'id' => $reservation->getId(),
            'customer_id' => $reservation->customer_id,
            'room_id' => $reservation->room_id,
            'status' => $reservation->status,
            'start_date' => $reservation->start_date,
            'end_date' => $reservation->end_date,
        ]);
    }

    public function test_show_returns_404_for_non_existing_reservation(): void
    {
        $nonExistingReservationId = 100;

        $response = $this->get(route('api.v1.reservations.show', ['reservation' => $nonExistingReservationId]));

        $response->assertNotFound();
    }
}
