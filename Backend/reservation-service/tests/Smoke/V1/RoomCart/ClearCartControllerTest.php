<?php

declare(strict_types=1);

namespace Tests\Smoke\V1\RoomCart;

use App\Models\Customer;
use Tests\Smoke\TestCase;

class ClearCartControllerTest extends TestCase
{
    public function test_success(): void
    {
        $customer = Customer::factory()->create();

        $response = $this->delete(route('api.v1.room_cart.clear', [
            'customer_id' => $customer->id,
        ]));

        $response->assertOk();
        $response->assertJson([
            'customer_id' => $customer->id,
            'items' => [],
        ]);
    }
}
