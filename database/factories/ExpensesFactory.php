<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Expenses;
use Faker\Generator as Faker;

$factory->define(Expenses::class, function (Faker $faker) {
    $users = User::all('id');
    return [
        'desc' =>$faker->word,
        'user_id' =>$faker->randomElement($users),
        'budget' =>$faker->randomNumber($nbDigits = NULL, $strict = false),
        'months_taken' =>$faker->randomNumber($nbDigits = NULL, $strict = false),
        'reason' =>$faker->word,
        'status' =>$faker->word,
    ];
});
