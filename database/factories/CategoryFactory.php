<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Chatter\Core\Models\CategoryInterface;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(model(CategoryInterface::class), function (Faker $faker) {
    $category = $faker->word;

    return [
        'name' => ucfirst($category),
        'slug' => Str::slug($category),
        'subtitle' => $faker->text,
        'color' => $faker->hexcolor,
        'order' => $faker->randomDigitNotNull,
        'created_at' => now(),
        'updated_at' => now()
    ];
});
