<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Game;
use Faker\Generator as Faker;

$factory->define(Game::class, function (Faker $faker) {
    return [
        'name' => $faker->domainWord,
        'owner_id' => $faker->numberBetween(1, 3),
        'url' => $faker->url,
        'email' => $faker->email
    ];
});
