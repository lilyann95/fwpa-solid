<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Savings;
use Faker\Generator as Faker;

$factory->define(Savings::class, function (Faker $faker) {
    
    $users = User::all('id');
    return [
        'monthly_contribution' =>$faker->randomNumber($nbDigits = NULL, $strict = false),
        'user_id' =>$faker->randomElement($users),
        'late_payment' =>$faker->randomNumber($nbDigits = NULL, $strict = false),
        'late_meeting' =>$faker->randomNumber($nbDigits = NULL, $strict = false),
        'absenteeism' =>$faker->randomNumber($nbDigits = NULL, $strict = false),
        'marriage' =>$faker->randomNumber($nbDigits = NULL, $strict = false),
        'birth' =>$faker->randomNumber($nbDigits = NULL, $strict = false),
        'graduation' =>$faker->randomNumber($nbDigits = NULL, $strict = false),
        'consecration' =>$faker->randomNumber($nbDigits = NULL, $strict = false),
        'sickness' =>$faker->randomNumber($nbDigits = NULL, $strict = false),
        'death' =>$faker->randomNumber($nbDigits = NULL, $strict = false),
        'total_amount' => $faker->randomNumber($nbDigits = NULL, $strict = false),
    ];
});
