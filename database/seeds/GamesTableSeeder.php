<?php
use Illuminate\Database\Seeder;

class GamesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Game::class, 4)->create()->each(function ($game) {
            $game->owner->save(factory(App\User::class)->make());
        });
    }
}
