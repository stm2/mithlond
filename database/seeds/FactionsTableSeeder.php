<?php
use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class FactionsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Faction::class, 2)->create([
            'user_id' => 1,
            'game_id' => 2
        ]);
        factory(App\Faction::class, 1)->create([
            'user_id' => 2,
            'game_id' => 2
        ]);

        $faker = Factory::create();

        for ($i = 3; $i <= User::count(); ++ $i) {
            factory(App\Faction::class, 3)->create([
                'game_id' => function () use ($faker) {
                    return $faker->numberBetween(3, User::count());
                },
                'user_id' => $i
            ]);
        }
    }
}
