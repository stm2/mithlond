<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Game;
use Faker\Generator as Faker;

$factory->define(Game::class, function (Faker $faker) {
    return [
        'name' => $faker->domainWord,
        'description' => $faker->realText(),
        'user_id' => function () {
            return App\User::inRandomOrder()->first()->id;
        },
        'url' => $faker->url,
        'email' => $faker->email
    ];
});
