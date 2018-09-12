<?php

use Faker\Generator as Faker;

$factory->define(App\ogmInOutFile::class, function (Faker $faker) {
    return [
        'date' => $faker->date(),
        'to' => $faker->name(),
        'from' => $faker->name(),
        'name' => $faker->name(),
        'subject' => $faker->sentence(10),
        'letter' => $faker->boolean(),
    ];
});
