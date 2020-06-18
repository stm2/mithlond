<?php
namespace Tests\Unit;

use App\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        // $game = factory(Game::class)->create();
        // TODO
        $this->assertEquals(1, 1);
    }
}
