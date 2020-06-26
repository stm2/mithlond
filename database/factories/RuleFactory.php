<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Rule;
use Faker\Generator as Faker;

$factory->define(Rule::class, function (Faker $faker) {
    return [
        'type' => 1,
        'name' => 'None',
        'description' => "No checks",
        'options' => json_encode([
            'type' => 'NONE'
        ])
    ];
});
