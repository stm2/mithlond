<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Game;
use App\User;

class UserMenuTest extends TestCase
{

    use RefreshDatabase;

    public function testHomeIsRedirect()
    {
        $response = $this->get('/home');

        $response->assertStatus(302);
        $response->assertRedirect("http://localhost/login");
    }

    public function testDashboardContainsMenu()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->withSession([
            'foo' => 'bar'
        ])
            ->get('/home');

        $response->assertStatus(200);
        $response->assertSeeText("My Games");
        $response->assertSeeText("You have no games.");
        $response->assertSee('<a href="/game/create">Create new game</a>', false);
    }

    public function testDashboardListsGames()
    {
        factory(User::class, 3)->create();
        $user = factory(User::class)->create();
        $games = factory(Game::class, 3)->create();
        $games = factory(Game::class, 2)->create([
            'name' => 'Test game 1',
            'owner_id' => 4
        ]);

        $response = $this->actingAs($user)->get('/home');

        $response->assertStatus(200);
        $response->assertSeeText("You have 2 games.");
        $response->assertSeeText("Test game 1 edit delete");
    }
}
