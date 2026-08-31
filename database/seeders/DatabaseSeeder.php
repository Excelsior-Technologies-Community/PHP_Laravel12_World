<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $india = Country::create([
            'name'      => 'India',
            'iso_code'  => 'IN',
            'capital'   => 'New Delhi',
            'currency'  => 'INR',
            'flag'      => '🇮🇳',
            'is_active' => true,
        ]);

        $gujarat = State::create(['country_id' => $india->id, 'name' => 'Gujarat', 'is_active' => true]);
        $maharashtra = State::create(['country_id' => $india->id, 'name' => 'Maharashtra', 'is_active' => true]);

        foreach (['Ahmedabad', 'Surat', 'Vadodara', 'Rajkot'] as $city) {
            City::create(['state_id' => $gujarat->id, 'country_id' => $india->id, 'name' => $city, 'is_active' => true]);
        }
        foreach (['Mumbai', 'Pune', 'Nagpur'] as $city) {
            City::create(['state_id' => $maharashtra->id, 'country_id' => $india->id, 'name' => $city, 'is_active' => true]);
        }

        $usa = Country::create([
            'name'      => 'United States',
            'iso_code'  => 'US',
            'capital'   => 'Washington, D.C.',
            'currency'  => 'USD',
            'flag'      => '🇺🇸',
            'is_active' => true,
        ]);

        $california = State::create(['country_id' => $usa->id, 'name' => 'California', 'is_active' => true]);

        foreach (['Los Angeles', 'San Francisco', 'San Diego'] as $city) {
            City::create(['state_id' => $california->id, 'country_id' => $usa->id, 'name' => $city, 'is_active' => true]);
        }

        // Extra dummy data via factories
        Country::factory(5)->create()->each(function ($country) {
            State::factory(2)->create(['country_id' => $country->id])->each(function ($state) {
                City::factory(3)->create([
                    'state_id'   => $state->id,
                    'country_id' => $state->country_id,
                ]);
            });
        });
    }
}
