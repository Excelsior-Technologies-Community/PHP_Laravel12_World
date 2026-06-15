<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::withCount('cities')
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->orderBy('id', 'asc')
            ->paginate(4)
            ->withQueryString();

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

    public function export()
    {
        $fileName = 'countries.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function () {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID',
                'Country Name',
                'Total Cities',
                'Created At'
            ]);

            $countries = Country::withCount('cities')->get();

            foreach ($countries as $country) {

                fputcsv($file, [
                    $country->id,
                    $country->name,
                    $country->cities_count,
                    $country->created_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    
    public function destroy(Country $country)
    {
        $country->delete();

        return redirect()->route('countries.index')

            ->with('success', 'Country deleted successfully!');
    }
}
