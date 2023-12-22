<?php

declare(strict_types=1);

namespace Tests\Smoke\V1\RoomCart;

use App\Models\Customer;
use Symfony\Component\HttpFoundation\Response;
use Tests\Smoke\TestCase;

class RemoveFromCartControllerTest extends TestCase
{
    public function test_success(): void
    {
        $customer = Customer::factory()->create();

        $response = $this->delete(route('api.v1.room_cart.remove_item', [
            'customer_id' => $customer->id,
            'room_id' => 12,
        ]));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
