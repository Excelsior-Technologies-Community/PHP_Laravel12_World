<?php

namespace Database\Factories;

use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    public function definition(): array
    {
        $state = State::factory()->create();

        return [
            'state_id'   => $state->id,
            'country_id' => $state->country_id,
            'name'       => fake()->city(),
            'is_active'  => true,
        ];
    }
}
