<?php

namespace Database\Factories;

use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;


class ProductVariantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductVariant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $variants=['xanh','trắng','đen','vàng','đỏ','15inch','17inch','tím','hồng','s','m','l','xl','xxl','13inch','50cc','69cc','lucky','drum','vodka'];
        return [
            'product_id' => fake()->numberBetween(1,500),
            'name' => Arr::random($variants),
            'image' => 'https://picsum.photos/'.fake()->numberBetween(400, 500),
            'sku' => fake()->text(5),
            'price' => round(fake()->numberBetween(150000,20000000),-3),
            'is_default' => fake()->boolean(),
            'width' =>fake()->numberBetween(5,200),
            'long' => fake()->numberBetween(5,200),
            'height' =>fake()->numberBetween(5,200),
            'weight' => fake()->numberBetween(50,20000),

        ];
    }
}
