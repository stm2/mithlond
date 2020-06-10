<?php
namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateGameTest extends TestCase
{

    use RefreshDatabase;

    protected $valid_game = [
        'name' => 'My game',
        'description' => 'Example description.',
        'url' => 'http://example.com',
        'email' => 'me@mygame.io'
    ];

    function test_user_can_create_game()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/games', $this->valid_game);

        $this->assertDatabaseHas('games', [
            'name' => 'My game',
            'owner_id' => $user->id
        ]);

        $response->assertStatus(302)->assertHeader('Location', url('/home'));

        $this->actingAs($user)
            ->get('/home')
            ->assertSee('My game');
    }

    function test_game_is_not_created_if_validation_fails()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/games');

        $response->assertSessionHasErrors([
            'name',
            'email'
        ]);
    }

    function test_name_max_length_bad()
    {
        $user = factory(User::class)->create();

        $this->valid_game['name'] = str_repeat('x', 256);

        $response = $this->actingAs($user)->post('/games', $this->valid_game);

        $response->assertSessionHasErrors([
            'name'
        ]);
    }

    function test_name_max_length_good()
    {
        $user = factory(User::class)->create();

        $this->valid_game['name'] = str_repeat('x', 255);

        $response = $this->actingAs($user)->post('/games', $this->valid_game);

        $this->assertDatabaseHas('games', $this->valid_game);
    }

    function test_email_valid()
    {
        $user = factory(User::class)->create();

        $this->valid_game['email'] = 'x@foo'; // FIXME this should not pass

        $response = $this->actingAs($user)->post('/games', $this->valid_game);

        $response->assertSessionHasErrors([
            'email'
        ]);
    }

    function test_guest_cannot_create()
    {
        $user = factory(User::class)->create();

        $response = $this->post('/games', [
            'name' => 'My game',
            'description' => 'Example description.',
            'url' => 'http://example.com',
            'email' => 'me@mygame.io'
        ]);

        $this->assertDatabaseMissing('games', [
            'name' => 'My game',
            'owner_id' => $user->id
        ]);

        $response->assertStatus(302)->assertHeader('Location', url('/login'));

        $this->actingAs($user)
            ->get('/home')
            ->assertDontSeeText('My game');
    }
}
