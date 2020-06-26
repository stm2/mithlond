<?php
namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WelcomeTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testEmpty()
    {
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee("There are no games.")
            ->assertSee("Login")
            ->assertSee("Register");
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLoggedIn()
    {
        $this->seed();

        $user = User::find(1);
        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200)
            ->assertSee("There are 7 game(s) with 9 faction(s) and 4 player(s).")
            ->assertSee("My Games")
            ->assertSee("Home");
    }
}
