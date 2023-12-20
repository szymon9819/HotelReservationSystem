<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api\V1\Reservation;

use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Room;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\TestCase;

class CreateControllerTest extends TestCase
{
    public function test_store_creates_new_reservation(): void
    {
        $customer = Customer::factory()->create();
        $room = Room::factory()->create();
        $data = [
            'customer_id' => $customer->id,
            'room_id' => $room->id,
            'start_date' => '2023-12-01',
            'end_date' => '2023-12-05',
        ];

        $response = $this->post(route('api.v1.reservations.store', $data));

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseCount(Reservation::class, 1);
    }

    public function test_store_failed_for_not_existing_customer(): void
    {
        $customer = Customer::factory()->create();

        $data = [
            'customer_id' => $customer->id,
            'start_date' => '2023-12-01',
            'end_date' => '2023-12-05',
        ];

        $response = $this->post(route('api.v1.reservations.store', $data));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_store_failed_for_not_existing_room(): void
    {
        $data = [
            'customer_id' => 22,
            'start_date' => '2023-12-01',
            'end_date' => '2023-12-05',
        ];

        $response = $this->post(route('api.v1.reservations.store', $data));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
