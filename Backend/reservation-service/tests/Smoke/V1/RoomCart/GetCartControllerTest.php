<?php

declare(strict_types=1);

namespace Tests\Smoke\V1\RoomCart;

use App\Models\Customer;
use Tests\Smoke\TestCase;

class GetCartControllerTest extends TestCase
{
    public function test_success(): void
    {
        $customer = Customer::factory()->create();

        $response = $this->get(route('api.v1.room_cart.get', [
            'customer_id' => $customer->id,
        ]));

        $response->assertOk();
        $response->assertJson([
            'customer_id' => $customer->id,
            'items' => [],
        ]);
    }
}
