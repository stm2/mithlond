<?php
namespace Tests\Feature;

use App\Faction;
use App\Game;
use App\Submission;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GameSubmissionsTest extends TestCase
{

    use RefreshDatabase;

    public function testViewForm()
    {
        $this->seed();
        $user = User::find(1);
        $faction = Faction::find(1);

        $response = $this->actingAs($user)->get('/factions/1/submissions/create');

        $response->assertStatus(200);
        $response->assertSee("Upload orders for faction " . $faction->name);
    }

    public function testSubmitSubmissions()
    {
        $this->seed();
        $user = User::find(1);

        $submission = [
            'text' => "Hello, Submissions!"
        ];
        $response = $this->actingAs($user)->post('/factions/1/submissions', $submission);

        $response->assertStatus(302)->assertHeader('Location', url('/home'));

        $this->assertDatabaseHas('submissions', $submission);
        $submission = Submission::find(Submission::all()->count());
        $this->assertEquals(1, $submission->faction_id);

        $game = Game::find(Faction::find(1)->game_id);
        $this->assertEquals($game->currentRound->round, $submission->round);
    }

    public function testUserAuthorized()
    {
        $this->seed();
        $user = User::find(2);

        $submission = [
            'text' => "Hello, Submissions!"
        ];
        $response = $this->actingAs($user)->post('/factions/1/submissions', $submission);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('submissions', $submission);
    }
}
