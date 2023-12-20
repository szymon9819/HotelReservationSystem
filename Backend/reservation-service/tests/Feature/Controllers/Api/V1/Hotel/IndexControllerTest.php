<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Api\V1\Hotel;

use App\Models\Hotel;
use Tests\Feature\TestCase;

class IndexControllerTest extends TestCase
{
    private const HOTEL_NUMBER = 5;

    public function test_index_returns_all_hotels(): void
    {
        Hotel::factory()->count(self::HOTEL_NUMBER)->create();

        $response = $this->get(route('api.v1.hotels.index', [
            'limit' => 10,
        ]));

        $response->assertOk()
            ->assertJsonCount(self::HOTEL_NUMBER, 'data');
    }
}
