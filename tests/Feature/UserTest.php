<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test on create user
     *
     * @return void
     */
    public function test_user_create()
    {
        $response = $this->post('api/user/create',
            [
                'name' => 'Test User',
                'access_admin' => '0',
                'password' => 'password',
            ],
            [
                'Authorization' => env('ADMIN_TOKEN')
            ]);

        $this->assertAuthenticated();

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User'
        ]);
    }

    /**
     * Test on update user
     *
     * @return void
     */
    public function test_user_update()
    {
        $user = User::factory()->create();

        $this->putJson("api/user/{$user->id}",
            [
                'access_admin' => '1'
            ],
            [
                'Authorization' => env('ADMIN_TOKEN')
            ])
            ->assertStatus(200)
            ->assertJsonFragment(['access_admin' => '1']);
    }

    /**
     * Test on deleted user
     *
     * @return void
     */
    public function test_user_deleted()
    {
        $user = User::factory()->create();

        $this->delete("api/user/{$user->id}", [],
            [
                'Authorization' => env('ADMIN_TOKEN')
            ])
            ->assertStatus(200);
    }
}
