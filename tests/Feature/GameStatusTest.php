<?php
namespace Tests\Feature;

use App\Game;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GameStatusTest extends TestCase
{

    use RefreshDatabase;

    public function testGameShowing()
    {
        $this->seed();

        $user = User::find(1);

        $response = $this->actingAs($user)->get('/games/2');

        $game = Game::find(2);
        $this->assertEquals($user->id, $game->owner_id);
        $response->assertSeeText("Status of " . $game->name);
        $response->assertSeeText("Status: " . $game->status);
        $response->assertSeeText("Next turn: " . $game->currentRound->round . " (" . $game->currentRound->deadline . ") edit add");
        $response->assertSeeText($game->roundsSent->count() . " / " . $game->rounds->count() . " turns");
        // $response->assertSeeText("Active factions: " . $game->factions->count() . " / " . $game->rounds->count() . " turns");
    }

    public function testNonOwnerSeesNothing()
    {
        $this->seed();

        $user = User::find(3);

        $response = $this->actingAs($user)->get('/games/2');

        $game = Game::find(2);
        $this->assertNotEquals($user->id, $game->owner_id);

        $response->assertStatus(403);
    }

    public function testNoTurns()
    {
        $this->seed();

        $user = User::find(2);

        $response = $this->actingAs($user)->get('/games/3');

        $game = Game::find(3);
        $this->assertEquals($user->id, $game->owner_id);

        $response->assertSeeText("Status of " . $game->name);
        $response->assertSeeText("Status: " . $game->status);
        $response->assertSeeText("Next turn: not set add");
        $response->assertSeeText($game->roundsSent->count() . " / " . $game->rounds->count() . " turns");
    }
}
