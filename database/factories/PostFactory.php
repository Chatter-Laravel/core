<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Chatter\Core\Models\Post;

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

$factory->define(Post::class, function (Faker $faker) {
    return [
        'body' => $faker->text(300),
        'user_id' => model_instance(config('chatter.user.namespace'))->all()->random(),
        'created_at' => now(),
        'updated_at' => now(),
        'deleted_at' => $faker->boolean(5) ? now() : null
    ];
});

// Link user to active users on the discussion
$factory->afterCreating(Post::class, function ($post, $faker) {
    $post->discussion->users()->save($post->discussion->user);
});
