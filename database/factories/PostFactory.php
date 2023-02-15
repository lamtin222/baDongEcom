<?php

namespace Database\Factories\Admin;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;


class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'author_id' => $this->faker->word,
            'category_id' => $this->faker->word,
            'title' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'seo_title' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'excerpt' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'body' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'image' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'slug' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'meta_description' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'meta_keyword' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'status' => $this->faker->word,
            'featured' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
