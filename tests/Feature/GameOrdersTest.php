<?php
namespace Tests\Feature;

use App\Faction;
use App\Game;
use App\Order;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GameOrdersTest extends TestCase
{

    use RefreshDatabase;

    public function testViewForm()
    {
        $this->seed();
        $user = User::find(1);
        $faction = Faction::find(1);

        $response = $this->actingAs($user)->get('/factions/1/orders/create');

        $response->assertStatus(200);
        $response->assertSee("Upload orders for faction " . $faction->name);
    }

    public function testSubmitOrders()
    {
        $this->seed();
        $user = User::find(1);

        $submission = [
            'orders' => "Hello, Orders!"
        ];
        $response = $this->actingAs($user)->post('/factions/1/orders', $submission);

        $response->assertStatus(302)->assertHeader('Location', url('/home'));

        $this->assertDatabaseHas('orders', $submission);
        $order = Order::find(Order::all()->count());
        $this->assertEquals(1, $order->faction_id);

        $game = Game::find(Faction::find(1)->game_id);
        $this->assertEquals($game->currentRound->round, $order->round);
    }

    public function testUserAuthorized()
    {
        $this->seed();
        $user = User::find(2);

        $submission = [
            'orders' => "Hello, Orders!"
        ];
        $response = $this->actingAs($user)->post('/factions/1/orders', $submission);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('orders', $submission);
    }
}
