<?php
use Illuminate\Database\Seeder;
use App\Game;
use Faker\Factory;

class GamesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Game::class, 2)->create([
            'owner_id' => 1
        ]);

        factory(App\Game::class, 1)->create([
            'owner_id' => 2
        ]);

        factory(App\Game::class, 4)->create();

        factory(App\Round::class, 5)->create([
            'game_id' => 1
        ]);

        $faker = Factory::create();

        $sent = $faker->dateTimeBetween('-20 days', 'now');
        for ($round = 0; $round < 6; ++ $round) {
            $deadline = $faker->dateTimeBetween($sent, (clone $sent)->add(date_interval_create_from_date_string("20 days")));
            $sent = $faker->dateTimeBetween($deadline, (clone $deadline)->add(date_interval_create_from_date_string("28 hours")));

            factory(App\Round::class)->create([
                'game_id' => 2,
                'round' => $round,
                'deadline' => $deadline,
                'sent' => $round > 3 ? null : $sent
            ]);
        }
        $game = Game::find(1);
        $game->current_round_id = 1;
        $game->save();
        $game = Game::find(2);
        $game->current_round_id = App\Round::where('game_id', 2)->whereNull('sent')->first()->id;
        $game->save();
    }
}
