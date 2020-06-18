<?php
namespace Tests\Feature;

use App\Game;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteGameTest extends TestCase
{
    use RefreshDatabase;

    protected $valid_game = [
        'name' => 'My game',
        'description' => 'Example description.',
        'url' => 'http://example.com',
        'email' => 'me@mygame.io'
    ];

    protected $user, $game;

    function init_db()
    {
        $this->user = factory(User::class)->create();
        $this->valid_game['user_id'] = $this->user->id;
        $this->game = factory(Game::class)->create($this->valid_game);

        // $response = $this;
        // if ($as_user) {
        // $response = $response->actingAs($this->user);
        // }
        // if (is_null($post)) {
        // $response = $response->get("/games/" . $this->game->id . "/edit", [
        // 'game' => $this->game
        // ]);
        // } else {
        // $response = $response->put("/games/" . $this->game->id, $post);
        // }

        // return $response;
    }

    function query(array $params = [], $method = 'DELETE', bool $as_user = true)
    {
        $response = $this;
        if ($as_user) {
            $response = $this->actingAs($this->user);
        }
        if ($method == 'DELETE')
            return $response->delete('/games/' . $this->game->id, $params);
        else if ($method == 'confirm')
            return $response->get('/games/' . $this->game->id . "/confirm_delete", $params);
        else
            return $response->get('/games/' . $this->game->id . "/delete", $params);
    }

    function test_confirm_shows()
    {
        $this->init_db();

        $response = $this->query([], 'confirm');
        $response->assertStatus(200)
            ->assertSee('Confirm Deletion')
            ->assertSeeText("Do you really")
            ->assertSee('Yes')
            ->assertSee("No");
    }

    function test_user_can_delete_game()
    {
        $this->init_db();
        $this->assertDatabaseHas('games', [
            'name' => 'My game'
        ]);

        $response = $this->query([
            'confirm_delete' => ''
        ]);

        $this->assertDatabaseMissing('games', [
            'name' => 'My game'
        ]);

        $response->assertStatus(302)->assertHeader('Location', url('/home'));
    }

    function test_user_needs_confirm()
    {
        $this->init_db();
        $this->assertDatabaseHas('games', [
            'name' => 'My game'
        ]);

        $response = $this->query([]);

        $this->assertDatabaseHas('games', [
            'name' => 'My game'
        ]);

        $response->assertStatus(302)->assertHeader('Location', url('/home'));
    }

    function test_user_needs_delete()
    {
        $this->init_db();
        $this->assertDatabaseHas('games', [
            'name' => 'My game'
        ]);

        $response = $this->query([
            'confirm_delete' => ''
        ], 'put');

        $this->assertDatabaseHas('games', [
            'name' => 'My game'
        ]);

        $response->assertStatus(404);
    }

    function test_guest_cannot_delete()
    {
        $this->init_db();
        $this->assertDatabaseHas('games', [
            'name' => 'My game'
        ]);

        $response = $this->query([
            'confirm_delete' => ''
        ], 'DELETE', false);

        $this->assertDatabaseHas('games', [
            'name' => 'My game'
        ]);

        $response->assertStatus(302)->assertHeader('Location', url('/login'));
    }
}
