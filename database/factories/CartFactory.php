<?php

namespace Database\Factories;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Factories\Factory;


class CartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cart::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'qty' => $this->faker->word,
            'customer_id' => $this->faker->word,
            'product_id' => $this->faker->word,
            'variant_id' => $this->faker->word,
            'disamount' => $this->faker->word,
            'distype' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'semi_total' => $this->faker->word,
            'price_total' => $this->faker->word,
            'ori_price' => $this->faker->word,
            'ori_offer_price' => $this->faker->word,
            'tax_amount' => $this->faker->word,
            'tax_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'ship_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'store_id' => $this->faker->word,
            'shipping' => $this->faker->word,
            'coupan_id' => $this->faker->word,
            'gift_pkg_charge' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
