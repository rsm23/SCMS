<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    $title = $faker->sentence;
    return [
        'title' => $title,
        'user_id' => 1,
        'body' => $faker->paragraph()
    ];
});
