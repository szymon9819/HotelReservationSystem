<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api\V1\Reservation;

use App\Models\Reservation;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\TestCase;

class CancelControllerTest extends TestCase
{
    public function test_cancel(): void
    {
        $reservation = Reservation::factory()->create();

        $response = $this->post(route('api.v1.reservations.cancel', [
            'reservation' => $reservation,
        ]));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_cancel_returns_404_for_non_existing_reservation(): void
    {
        $nonExistingReservationId = 100;

        $response = $this->post(route('api.v1.reservations.cancel', [
            'reservation' => $nonExistingReservationId
        ]));

        $response->assertNotFound();
    }
}
