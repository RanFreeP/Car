<?php

namespace Tests\Feature;

use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarTest extends TestCase
{
    /**
     * Test on create car
     *
     * @return void
     */
    public function test_car_create()
    {
        $response = $this->post('api/car/create',
            [
                'mark' => 'Toyota',
                'model' => 'Prius',
                'year' => '2025',
            ],
            [
                'Authorization' => env('ADMIN_TOKEN'),
            ]);

        $this->assertAuthenticated();

        $response->assertStatus(200);

        $this->assertDatabaseHas('cars', [
            'mark' => 'Toyota',
            'model' => 'Prius',
            'year' => '2025',
        ]);
    }

    /**
     * Test on update car
     *
     * @return void
     */
    public function test_car_update()
    {
        $car = Car::factory()->create();

        $this->putJson("api/car/{$car->id}",
            [
                'mark' => 'honda',
            ],
            [
                'Authorization' => env('ADMIN_TOKEN'),
            ])
            ->assertStatus(200)
            ->assertJsonFragment(['mark' => 'honda']);
    }

    /**
     * Test on deleted car
     *
     * @return void
     */
    public function test_car_deleted()
    {
        $car = Car::factory()->create();

        $this->delete("api/car/{$car->id}", [],
            [
                'Authorization' => env('ADMIN_TOKEN'),
            ])
            ->assertStatus(200);
    }
}
