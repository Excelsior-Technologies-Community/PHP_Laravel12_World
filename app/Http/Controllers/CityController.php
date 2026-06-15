<?php

namespace App\Http\Controllers;

use App\Models\City;        
use App\Models\Country;     
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $cities = City::with('country')
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhereHas('country', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            })
            ->orderBy('id', 'asc')
            ->paginate(3)
            ->withQueryString();

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
