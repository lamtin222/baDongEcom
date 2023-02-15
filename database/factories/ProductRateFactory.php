<?php

namespace Database\Factories;

use App\Models\ProductRate;
use Illuminate\Database\Eloquent\Factories\Factory;


class ProductRateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductRate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'product_id' => $this->faker->word,
            'rate' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'avg_rate' => $this->faker->word,
            'total' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
