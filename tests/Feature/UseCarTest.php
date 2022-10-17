<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UseCarTest extends TestCase
{
    /**
     * Test on create car
     *
     * @return void
     */
    public function test_car_create()
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();

        $response = $this->post('api/useCar',
            [
                'car_id' => $car->id,
                'user_id' => $user->id,
            ],
            [
                'Authorization' => env('ADMIN_TOKEN')
            ]);

        $this->assertAuthenticated();

        $response->assertStatus(200);

        $this->assertDatabaseHas('use_user_car', [
            'car_id' => $car->id,
            'user_id' => $user->id,
        ]);
    }
}
