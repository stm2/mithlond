<?php
use App\Faction;
use Faker\Factory;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Order::class)->create([
            'faction_id' => 1,
            'round' => 4
        ]);
        factory(App\Order::class)->create([
            'faction_id' => 1,
            'round' => 5
        ]);

        $faker = Factory::create();

        factory(App\Order::class, 5)->create([
            'faction_id' => function () use ($faker) {
                return $faker->numberBetween(3, Faction::count());
            }
        ]);
    }
}
