<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Status;
use Faker\Generator as Faker;

$factory->define(Status::class, function (Faker $faker) {
    return [
        'user_id'=>$faker->numberBetween($min=1,$max=5),
        'body'=>$faker->text($maxNbChars=50)
    ];
});
