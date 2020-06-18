<?php
namespace Tests\Feature;

use App\Game;
use App\Order;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Testing\TestResponse;
use App\Faction;

class GameStatusTest extends TestCase
{

    use RefreshDatabase;

    public function testGameShowing()
    {
        $this->seed();

        $user = User::find(1);

        $response = $this->actingAs($user)->get('/games/2');

        $game = Game::find(2);
        $this->assertEquals($user->id, $game->user_id);
        $this->assertGreaterThan(1, $game->currentRound->round);
        $this->assertGreaterThan(1, $game->roundsSent->count());
        $this->assertGreaterThan(1, $game->factions->count());

        $response->assertSeeText("Status of " . $game->name);
        $response->assertSeeText("Status: " . $game->status);
        $response->assertSeeTextInOrder([
            "Next turn: " . $game->currentRound->round,
            "(" . $game->currentRound->deadline . ")",
            "edit",
            "add"
        ]);

        $response->assertSeeText($game->roundsSent->count() . " / " . $game->rounds->count() . " turns");

        $response->assertSeeText("Active factions: " . $game->factions->count());
        $response->assertSeeText("Active players: 2");

        $response->assertSeeText("Orders received: 1, nmr: 2");

        $content = $response->getContent();
        $this->assertRegExp("#<a[^>]*href=\"/games/2/orders\"[^>]*>Download orders</a>#", $content);
    }

    public function testNonOwnerSeesNothing()
    {
        $this->seed();

        $user = User::find(3);

        $response = $this->actingAs($user)->get('/games/2');

        $game = Game::find(2);
        $this->assertNotEquals($user->id, $game->user_id);

        $response->assertStatus(403);
    }

    public function testNoTurns()
    {
        $this->seed();

        $user = User::find(2);

        $response = $this->actingAs($user)->get('/games/3');

        $game = Game::find(3);
        $this->assertEquals($user->id, $game->user_id);

        $response->assertSeeText("Status of " . $game->name);
        $response->assertSeeText("Status: " . $game->status);
        $response->assertSeeText("Next turn: not set add");
        $response->assertSeeText($game->roundsSent->count() . " / " . $game->rounds->count() . " turns");
    }

    public function testNoFactions()
    {
        $this->seed();

        $user = User::find(1);

        $response = $this->actingAs($user)->get('/games/1');

        $game = Game::find(1);
        $this->assertEquals($user->id, $game->user_id);

        $response->assertSeeText("Active factions: 0");
        $response->assertSeeText("Active players: 0");
        $response->assertSeeText($game->roundsSent->count() . " / " . $game->rounds->count() . " turns");
    }

    public function testNoOrders()
    {
        $this->seed();

        $user = User::find(1);

        $response = $this->actingAs($user)->get('/games/1');

        $game = Game::find(1);
        $this->assertEquals($user->id, $game->user_id);

        $response->assertSeeText("Orders received: 0, nmr: 0");
    }

    public function testManage()
    {
        $this->fail();
    }

    public function testManageUnauthorized()
    {
        $this->fail();
    }

    public function testDownloadOrders()
    {
        $this->seed();
        $user = User::find(1);
        $allOrders = "";
        $faction = Faction::find(1);
        $this->assertEquals(2, $faction->game_id);
        for ($i = 1; $i <= 2; ++ $i) {
            $order = Order::find($i);
            $this->assertEquals($faction->id, $order->faction_id);
            $allOrders .= $order->orders;
            $allOrders .= "\n";
        }
        $this->assertGreaterThan(10, strlen($allOrders));

        $response = $this->actingAs($user)->get('/games/2/orders');

        $response->assertStatus(200)->assertSee($allOrders);
    }

    public function testDownloadUnauthorizedOrders()
    {
        $this->seed();
        $user = User::find(2);

        $faction = Faction::find(1);
        $this->assertEquals(2, $faction->game_id);
        $this->assertNotEquals($faction->game->user_id, $user->id);
        $this->assertEquals($faction->game->user_id, 1);

        $game = Game::find(2);
        $this->assertNotEquals($game->user_id, $user->id);

        $response = $this->actingAs($user)->get('/games/2/orders');

        $response->assertStatus(403);
    }
}
