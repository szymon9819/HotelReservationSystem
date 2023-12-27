<?php

declare(strict_types=1);

namespace Tests\Smoke\V1\RoomCart;

use App\Models\Customer;
use App\Models\Room;
use Symfony\Component\HttpFoundation\Response;
use Tests\Smoke\TestCase;

class AddToCartControllerTest extends TestCase
{
    public function test_success(): void
    {
        $customer = Customer::factory()->create();
        $room = Room::factory()->create();

        $response = $this->post(route('api.v1.room_cart.add_item', [
            'customer_id' => $customer->id,
            'room_id' => $room->id,
        ]));

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_room_is_locked(): void
    {
        $customer = Customer::factory()->create();
        $room = Room::factory()->create();

        $firstResponse = $this->post(route('api.v1.room_cart.add_item', [
            'customer_id' => Customer::factory()->create()->id,
            'room_id' => $room->id,
        ]));
        $response = $this->post(route('api.v1.room_cart.add_item', [
            'customer_id' => $customer->id,
            'room_id' => $room->id,
        ]));

        $firstResponse->assertStatus(Response::HTTP_CREATED);
        $response->assertStatus(Response::HTTP_CONFLICT);
    }
}
