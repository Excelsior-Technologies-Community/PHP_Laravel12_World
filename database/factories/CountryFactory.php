<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->country();

        return [
            'name'      => $name,
            'iso_code'  => fake()->unique()->countryCode(),
            'capital'   => fake()->city(),
            'currency'  => fake()->currencyCode(),
            'flag'      => '🏳️',
            'is_active' => true,
        ];
    }
}
