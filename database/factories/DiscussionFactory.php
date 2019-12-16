<?php

use Illuminate\Support\Str;
use Chatter\Core\Models\Post;
use Faker\Generator as Faker;
use Chatter\Core\Models\Category;
use Chatter\Core\Models\Discussion;

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

$factory->define(Discussion::class, function (Faker $faker) {
    $title = $faker->unique()->text(80);

    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'color' => $faker->hexcolor,
        'category_id' => Category::all()->random(),
        'user_id' => model_instance(config('chatter.user.namespace'))->all()->random(),
        'views' => $faker->numberBetween(0, 1000),
        'created_at' => $faker->dateTimeBetween('-20 days', 'now'),
        'updated_at' => null,
        'deleted_at' => $faker->boolean(5) ? now() : null,
        'last_reply_at' => now()
    ];
});

$factory->afterCreating(Discussion::class, function ($discussion, $faker) {
    $discussion->users()->save($discussion->user);
});

$factory->afterCreating(Discussion::class, function ($discussion, $faker) {
    for ($i = 0; $i < $faker->numberBetween(0, 100); $i++) {
        $post = factory(Post::class)->make();
        $discussion->posts()->save($post);

        try {
            $discussion->users()->save($post->user);
        } catch (\Exception $e) {}
    }
});
