<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AvionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'modele' => $this->faker->unique()->lexify('Modele ???'),
            'capacite' => $this->faker->numberBetween(50, 400),
        ];
    }
}
