<?php
namespace Tests\Feature;

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Faction;
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
        $response->assertSee('<a href="/games/create">Create new game</a>', false);

        $response->assertSeeText("My Factions");
        $response->assertSeeText("You have no factions.");
        $response->assertSee('<a href="/factions/apply">Apply for a game</a>', false);
    }

    public function testDashboardListsGames()
    {
        factory(User::class, 3)->create();
        $user = factory(User::class)->create();
        $games = factory(Game::class, 3)->create();
        $games = factory(Game::class, 2)->create([
            'name' => 'Test game 1',
            'user_id' => 4
        ]);
        $num = Game::where('user_id', $user->id)->count();
        $this->assertGreaterThan(1, $num);

        $response = $this->actingAs($user)->get('/home');

        $response->assertStatus(200);
        $response->assertSeeText("You have $num games.");
        $response->assertSeeText("Test game 1 manage edit delete");
    }

    public function testDashboardListsFactions()
    {
        factory(User::class, 3)->create();
        $user = factory(User::class)->create();
        $game = factory(Game::class)->create();

        $factions = factory(Faction::class)->create([
            'game_id' => $game->id,
            'number' => 'party',
            'user_id' => $user->id,
            'name' => 'Test faction 1'
        ]);
        $faker = Factory::create();

        $factions = factory(Faction::class)->create([
            'user_id' => $user->id,
            'game_id' => $game->id,
            'number' => $faker->word()
        ]);
        $num = Faction::where('user_id', $user->id)->count();
        $this->assertGreaterThan(1, $num);

        $response = $this->actingAs($user)->get('/home');

        $response->assertStatus(200);
        $response->assertSeeText("You have $num factions.");
        $response->assertSeeText("Test faction 1 (party): game " . $game->name . ", send orders, reports");
    }
}
