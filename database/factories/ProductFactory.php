<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;


class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'category_id' => fake()->numberBetween(1,15),
            'sku' => fake()->text(15),
            'name' => "product ".fake()->company(),
            'description' => fake()->text(fake()->numberBetween(5, 4096)),
            'body' => fake()->paragraph(fake()->numberBetween(5, 156)),
            'images' => json_encode(['https://picsum.photos/'.fake()->numberBetween(400, 500),'https://picsum.photos/'.fake()->numberBetween(400, 500)])

        ];
    }
}
