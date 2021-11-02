<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ElementFactory extends Factory
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
            'unit' => $this->faker->randomElement(),
            'category_id' => rand(1,50),
        ];
    }
}
