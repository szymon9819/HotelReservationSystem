<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api\V1\Reservation;

use App\Models\Customer;
use App\Models\Reservation;
use Tests\Feature\TestCase;

class IndexControllerTest extends TestCase
{
    private const RESERVATIONS_AMOUNT = 5;

    public function test_index_returns_all_reservations_for_customer(): void
    {
        $customer = Customer::factory()->create();
        Reservation::factory()->for($customer)
            ->count(self::RESERVATIONS_AMOUNT)
            ->create();

        $response = $this->get(route('api.v1.reservations.index', [
            'customer_id' => $customer->id,
            'limit' => 10,
        ]));

        $response->assertOk()
            ->assertJsonCount(self::RESERVATIONS_AMOUNT, 'data');
    }
}
