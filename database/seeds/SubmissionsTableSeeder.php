<?php
use App\Faction;
use Faker\Factory;
use Illuminate\Database\Seeder;

class SubmissionsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Submission::class)->create([
            'faction_id' => 1,
            'round' => 4
        ]);
        factory(App\Submission::class)->create([
            'faction_id' => 1,
            'round' => 5
        ]);

        $faker = Factory::create();

        factory(App\Submission::class, 5)->create([
            'faction_id' => function () use ($faker) {
                return $faker->numberBetween(3, Faction::count());
            }
        ]);
    }
}
