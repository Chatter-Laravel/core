<?php


namespace Database\Factories\Chatter\Core\Models;

use Chatter\Core\Models\Category;
use Chatter\Core\Models\Discussion;
use Chatter\Core\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DiscussionFactory extends Factory
{
    protected $model = Discussion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->unique()->text(80);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'color' => $this->faker->hexcolor,
            'category_id' => Category::all()->random(),
            'user_id' => model_instance(config('chatter.user.namespace'))->all()->random(),
            'views' => $this->faker->numberBetween(0, 1000),
            'created_at' => $this->faker->dateTimeBetween('-20 days', 'now'),
            'updated_at' => null,
            'deleted_at' => $this->faker->boolean(5) ? now() : null,
            'last_reply_at' => now()
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Discussion $discussion) {
            $discussion->users()->save($discussion->user);
        })->afterCreating(function (Discussion $discussion) {
            for ($i = 0; $i < $this->faker->numberBetween(1, 100); $i++) {
                $post = Post::factory()->make();
                $discussion->posts()->save($post);

                try {
                    $discussion->users()->save($post->user);
                } catch (\Exception $e) {
                }
            }
        });
    }
}
