<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\State>
 */
class StateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'country_id' => Country::factory(),
            'name'       => fake()->state(),
            'is_active'  => true,
        ];
    }
}
