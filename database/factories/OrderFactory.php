<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'faction_id' => function () {
            return App\Faction::inRandomOrder()->first()->id;
        },
        'round' => $faker->numberBetween(1, 10),
        'orders' => $faker->text(2000)
    ];
});
