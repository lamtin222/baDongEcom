<?php

namespace Database\Factories\Admin;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;


class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'parent_id' => $this->faker->word,
            'status' => $this->faker->boolean,
            'menu' => $this->faker->boolean,
            'title' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'slug' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'content' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'image' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'images' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'layout' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'order' => $this->faker->word,
            'seo' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'details' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
