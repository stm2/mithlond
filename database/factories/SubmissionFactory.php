<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Submission;
use Faker\Generator as Faker;

$factory->define(Submission::class, function (Faker $faker) {
    return [
        'faction_id' => function () {
            return App\Faction::inRandomOrder()->first()->id;
        },
        'round' => $faker->numberBetween(1, 10),
        'text' => $faker->text(2000)
    ];
});
