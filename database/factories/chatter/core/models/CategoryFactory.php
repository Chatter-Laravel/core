<?php

namespace Database\Factories\Chatter\Core\Models;

use Chatter\Core\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $category = $this->faker->unique()->word;

        return [
            'name' => Str::title($category),
            'slug' => Str::slug($category),
            'subtitle' => $this->faker->text,
            'color' => $this->faker->hexcolor,
            'order' => $this->faker->randomDigitNotNull,
            'created_at' => $this->faker->dateTimeBetween('-1 years', '-20 days'),
            'updated_at' => null
        ];
    }
}
