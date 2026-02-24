<?php

namespace App\Http\Controllers;

use App\Models\Country;   
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::latest()->get();
        return view('country.index', compact('countries'));
    }

    public function create()
    {
        return view('country.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Country::create([
            'name' => $request->name
        ]);

        return redirect()->route('countries.index')
    ->with('success', 'Country added successfully!');
    }
}