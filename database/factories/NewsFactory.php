<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\News;
use Faker\Generator as Faker;

$factory->define(News::class, function (Faker $faker) {

    return [
        'slug' => $faker->slug(10),
        'title' => $faker->sentence. '(новость)',
        'shortDescription' => $faker->sentence,
        'body' => $faker->text(1000),
        'owner_id' => 1,
    ];
});
