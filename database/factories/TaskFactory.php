<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {

    return [
        'description' => $faker->sentence,
        'day' => $faker->dateTimeBetween('yesterday', '+8 days')->format('Y-m-d'),
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
    ];

});
