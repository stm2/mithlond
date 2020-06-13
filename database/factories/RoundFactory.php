<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Round;
use Faker\Generator as Faker;

$round = 0;
$deadline = new DateTime();

$factory->define(Round::class, function (Faker $faker) use (&$round, &$deadline) {

    if (empty($deadline))
        $deadline->setTimestamp($faker->dateTimeBetween('-2 weeks', 'now')
            ->getTimestamp());

    $plustwo = clone $deadline;
    $plustwo->add(date_interval_create_from_date_string("2 hours"));
    $sent = $faker->dateTimeBetween($deadline, $plustwo);

    $result = [
        'round' => $round ++,
        'game_id' => function () {
            throw new Error('must define explicit game_id');
        },
        'deadline' => clone $deadline,
        'sent' => clone $sent
    ];

    $plustwo = clone $sent;
    $plustwo->add(date_interval_create_from_date_string("10 days"));
    $deadline->setTimestamp($faker->dateTimeBetween($sent, $plustwo)
        ->getTimestamp());

    return $result;
});
