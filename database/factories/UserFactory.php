<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, static function (Faker $faker) {
    return [
        'username' => $faker->unique()->userName,
        'name'     => $faker->name,
        'phone'    => '0' . $faker->randomNumber(9),
        'email'    => $faker->unique()->safeEmail,
        'password' => \Hash::make(123456), // secret
        'state'    => 1,
    ];
});
