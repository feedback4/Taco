<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'code' => $this->faker->name(),
            'texture' => $this->faker->name(),
            'formula_id' => 1,
            'category_id' => 8,
            'last_price' => rand(10,50),
        ];
    }
}
