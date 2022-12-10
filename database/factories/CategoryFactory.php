<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [

        'slug'       => $faker ->slug(),
        'is_active'  => $faker ->boolean(),
        'name'       => $faker -> word(),
    ];
});
