<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;


class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'username' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'password' => $this->faker->lexify('1???@???A???'),
            'email' => $this->faker->email,
            'phone_number' => $this->faker->numerify('0##########'),
            'name' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'address' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'remember_token' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'email_verified_at' => $this->faker->date('Y-m-d H:i:s'),
            'facebook_id' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'google_id' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
