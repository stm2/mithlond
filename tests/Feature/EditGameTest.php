<?php
namespace Tests\Feature;

use App\Game;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditGameTest extends TestCase
{
    use RefreshDatabase;

    protected $valid_game = [
        'name' => 'My game',
        'description' => 'Example description.',
        'url' => 'http://example.com',
        'email' => 'me@mygame.io'
    ];

    protected $user, $game;

    function user_response(array $post = null, bool $as_user = true)
    {
        $this->user = factory(User::class)->create();
        $this->valid_game['user_id'] = $this->user->id;
        $this->game = factory(Game::class)->create($this->valid_game);

        $response = $this;
        if ($as_user) {
            $response = $response->actingAs($this->user);
        }
        if (is_null($post)) {
            $response = $response->get("/games/" . $this->game->id . "/edit", [
                'game' => $this->game
            ]);
        } else {
            $response = $response->put("/games/" . $this->game->id, $post);
        }

        return $response;
    }

    function test_user_can_edit_game()
    {
        $response = $this->user_response();
        $response->assertStatus(200)
            ->assertSee('Update Game')
            ->assertSee('value="My game"', false);
    }

    function test_user_can_update_game()
    {
        $this->valid_game['name'] = 'My edited game';
        $response = $this->user_response($this->valid_game);
        $response->assertStatus(302)->assertHeader('Location', url('/home'));

        $this->assertDatabaseHas('games', $this->valid_game);
        $this->assertDatabaseMissing('games', [
            'name' => 'My new game'
        ]);

        $response->assertStatus(302)->assertHeader('Location', url('/home'));
    }

    function test_game_is_not_updated_if_validation_fails()
    {
        $edited = $this->valid_game;
        $edited['name'] = '';
        $edited['email'] = 'a';
        $response = $this->user_response($edited);

        $this->assertDatabaseHas('games', $this->valid_game);

        $response->assertStatus(302)->assertHeader('Location', url('/'));

        $response->assertSessionHasErrors([
            'name',
            'email'
        ]);
    }

    function test_name_max_length_bad()
    {
        $this->valid_game['name'] = str_repeat('x', 256);

        $response = $this->user_response($this->valid_game);

        $response->assertSessionHasErrors([
            'name'
        ]);
    }

    function test_name_max_length_good()
    {
        $user = factory(User::class)->create();

        $this->valid_game['name'] = str_repeat('x', 255);

        $response = $this->user_response($this->valid_game);

        $this->assertDatabaseHas('games', $this->valid_game);
    }

    function test_email_valid()
    {
        $user = factory(User::class)->create();

        $this->valid_game['email'] = 'x@foo'; // FIXME this should not pass

        $response = $this->user_response($this->valid_game);

        $response->assertSessionHasErrors([
            'email'
        ]);
    }

    function test_guest_cannot_edit()
    {
        $edited = $this->valid_game;
        $edited['name'] = "My edited game";
        $response = $this->user_response($edited, false);

        $this->assertDatabaseHas('games', $this->valid_game);
        $this->assertDatabaseMissing('games', [
            'name' => $edited['name']
        ]);

        $response->assertStatus(302)->assertHeader('Location', url('/login'));

        $this->actingAs($this->user)
            ->get('/home')
            ->assertSeeText('My game')
            ->assertDontSeeText('My edited game');
    }
}
