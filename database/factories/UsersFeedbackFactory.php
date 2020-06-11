<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Admin\Feedback;
use Faker\Generator as Faker;

$factory->define(Feedback::class, function (Faker $faker) {
    return [
        'email' => $faker->freeEmail,
        'feedback' => $faker->text(),
    ];
});
