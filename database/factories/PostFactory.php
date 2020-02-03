<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'slug' => $faker->slug(10),
        'title' => $faker->jobTitle,
        'shortDescription'=> $faker->text(),
        'body' => $faker->text(800),
        'publish' => $faker->boolean,
    ];
});
