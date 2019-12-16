<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Chatter\Core\Models\Category;
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

$factory->define(Category::class, function (Faker $faker) {
    $category = $faker->unique()->word;

    return [
        'name' => Str::title($category),
        'slug' => Str::slug($category),
        'subtitle' => $faker->text,
        'color' => $faker->hexcolor,
        'order' => $faker->randomDigitNotNull,
        'created_at' => $faker->dateTimeBetween('-1 years', '-20 days'),
        'updated_at' => null
    ];
});
