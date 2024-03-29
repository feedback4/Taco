<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FormulaFactory extends Factory
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
            'code' => $this->faker->postcode(),
            'category_id' => rand(1,50),
        ];
    }
}
