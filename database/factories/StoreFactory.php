<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;


class StoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Store::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'name' => fake()->name(),
            'banner' => fake()->imageUrl(1024,768),
            'address' => fake()->address(),
            'description' => fake()->paragraph(3)

        ];
    }
}
