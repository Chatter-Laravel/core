<?php

namespace Database\Factories\Chatter\Core\Models;

use Chatter\Core\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => $this->faker->text(300),
            'user_id' => model_instance(config('chatter.user.namespace'))->all()->random(),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => $this->faker->boolean(5) ? now() : null
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            $post->discussion->users()->save($post->discussion->user);
        });
    }
}
