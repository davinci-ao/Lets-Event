<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'category_id' => $faker->randomDigit,
        'date' => now(),
        'time' => date('G:i:s'),
        'price' => $faker->randomDigit,
        'location_id' => $faker->randomDigit,
        'user_id' => $faker->randomDigit,        
    ];
});
