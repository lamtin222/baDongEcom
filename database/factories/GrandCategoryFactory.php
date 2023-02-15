<?php

namespace Database\Factories;

use App\Models\GrandCategory;
use Illuminate\Database\Eloquent\Factories\Factory;


class GrandCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GrandCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'name' => $this->faker->text($this->faker->numberBetween(5, 10)),
            'icon' =>fake()->imageUrl(width:50,height:50,word:'product'),
            'color' =>fake()->hexColor()
        ];
    }
}
