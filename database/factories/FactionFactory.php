<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Faction;
use Faker\Generator as Faker;

$factory->define(Faction::class, function (Faker $faker) {
    return [
        'game_id' => function () {
            return App\Game::inRandomOrder()->first()->id;
        },
        'number' => $faker->unique()
            ->word(),
        'user_id' => function () {
            return App\User::inRandomOrder()->first()->id;
        },
        'name' => $faker->words(2, true)
    ];
});
