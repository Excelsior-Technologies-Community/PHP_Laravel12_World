<?php

namespace App\Http\Controllers;

use App\Models\City;        // 🔥 REQUIRED
use App\Models\Country;     // 🔥 REQUIRED
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::with('country')->get();
        return view('city.index', compact('cities'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('city.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'country_id' => 'required'
        ]);

        City::create([
            'name' => $request->name,
            'country_id' => $request->country_id
        ]);

       return redirect()->route('cities.index')
    ->with('success', 'City added successfully!');
    }
}