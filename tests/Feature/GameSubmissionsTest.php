<?php
namespace Tests\Feature;

use App\Faction;
use App\Game;
use App\Rule;
use App\Submission;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\App;
use Illuminate\Testing\TestResponse;

class GameSubmissionsTest extends TestCase
{

    use RefreshDatabase;

    private $valid_move = <<<'SUB'
ERESSEA 1 "p"
REGION 0,-11 ;a
; comm
EINHEIT x
ARBEITE; oder so
;comm
; comment; 
NÄcHSTER
SUB;

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
        $rule = Faction::find(1)->game->rule;
        $rule->options = \RulesTableSeeder::regexp_replace();
        $rule->save();

        $submission = [
            'text' => $this->valid_move
        ];
        $response = $this->actingAs($user)->post('/factions/1/submissions', $submission);

        $response->assertStatus(302)->assertHeader('Location', url('/home'));

        $this->assertDatabaseHas('submissions', $submission);
        $submission = Submission::find(Submission::all()->count());
        $this->assertEquals(1, $submission->faction_id);

        $game = Game::find(Faction::find(1)->game_id);
        $this->assertEquals($game->currentRound->round, $submission->round);
    }

    public function testInvalidSubmitSubmissions()
    {
        $this->seed();
        $user = User::find(1);
        $rule = Faction::find(1)->game->rule;
        $rule->options = \RulesTableSeeder::regexp_replace();
        $rule->save();

        $submission = [
            'text' => $this->valid_move . "#"
        ];
        $response = ($this->actingAs($user)->post('/factions/1/submissions', $submission));

        $response->assertSessionHasErrors([
            'text' => 'text is an invalid submission.'
        ]);
    }

    public function testSubmitSubmissionsStartEnd()
    {
        $this->seed();
        $user = User::find(1);
        $rule = Faction::find(1)->game->rule;
        $rule->options = \RulesTableSeeder::start_end_regexp();
        $rule->save();

        $submission = [
            'text' => $this->valid_move
        ];

        $response = $this->actingAs($user)->post('/factions/1/submissions', $submission);

        $response->assertStatus(302)->assertHeader('Location', url('/home'));

        $this->assertDatabaseHas('submissions', $submission);
        $submission = Submission::find(Submission::all()->count());
        $this->assertEquals(1, $submission->faction_id);

        $game = Game::find(Faction::find(1)->game_id);
        $this->assertEquals($game->currentRound->round, $submission->round);
    }

    public function testInvalidSubmitSubmissionsStartEnd()
    {
        $this->seed();
        $user = User::find(1);
        $rule = Faction::find(1)->game->rule;
        $rule->options = \RulesTableSeeder::start_end_regexp();
        $rule->save();

        $submission = [
            'text' => $this->valid_move . "#"
        ];
        $response = ($this->actingAs($user)->post('/factions/1/submissions', $submission));

        $response->assertSessionHasErrors([
            'text' => 'orders should end with  *N(AE|[Ää])CHSTER[ ;]*, found NÄcHSTER#'
        ]);
    }

    public function testUserAuthorized()
    {
        $this->seed();
        $user = User::find(2);

        $submission = [
            'text' => $this->valid_move
        ];
        $response = $this->actingAs($user)->post('/factions/1/submissions', $submission);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('submissions', $submission);
    }
}
