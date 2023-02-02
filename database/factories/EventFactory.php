<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Event::class, function (Faker $faker) {
    $month   = $faker->month;
    $day     = rand(1, 28);
    $startAt = "2018-{$month}-{$day} 00:00:00";
    $endtAt  = "2018-{$month}-{$day} 23:59:59";

    return [
        'title'       => $faker->sentence,
        'start_at'    => $startAt,
        'end_at'      => $endtAt,
        'description' => $faker->text(20),
        'color'       => $faker->safeHexColor
    ];
});
