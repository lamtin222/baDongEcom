<?php

namespace Database\Factories;

use App\Models\StoreCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Arr;
use App\Models\Store;
use Str;

class StoreCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StoreCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $cats=['Men','Woman','Pet','Backpack','Hand bag', 'Wallet','Food','Children','Other','Tools'];

        return [
            'store_id' => fake()->numberBetween(1,10),
            'grand_id' => fake()->numberBetween(1,10),
            'name'=>Arr::random($cats),
            'image' => fake()->imageUrl(1024,768,"",true,'category'),
            'slug' =>Str::slug(fake()->unique()->text(10)),

        ];
    }
}
