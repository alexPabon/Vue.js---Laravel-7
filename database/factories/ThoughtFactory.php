<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Thought;
use Faker\Generator as Faker;

$factory->define(Thought::class, function (Faker $faker) {
    return [
        'description'=>$faker->text($maxNbChar=50),
        'user_id'=>$faker->numberBetween($min=1,$max=5)
    ];
});
