<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'category_id' => function () {
            return factory('App\Category')->create()->id;
        },
        'title' => $faker->sentence,
        'body' => $faker->paragraph()
    ];
});
