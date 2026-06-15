<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::all();

        $cities = City::with('country')

            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhereHas('country', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            })

            ->when($request->country_id, function ($query) use ($request) {
                $query->where('country_id', $request->country_id);
            })

            ->orderBy('id', 'asc')
            ->paginate(4)
            ->withQueryString();

        return view('city.index', compact('cities', 'countries'));
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

    public function destroy(City $city)
    {
        $city->delete();

        return redirect()->route('cities.index')
            ->with('success', 'City deleted successfully!');
    }
}
