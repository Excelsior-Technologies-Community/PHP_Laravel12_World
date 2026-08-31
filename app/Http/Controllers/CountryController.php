<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use App\Http\Controllers\Concerns\CacheVersioning;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    use CacheVersioning;

    public function index(Request $request)
    {
        $countries = Cache::remember(
            $this->cacheKey($request, 'countries'),
            now()->addMinutes(10),
            function () use ($request) {
                return Country::withCount(['states', 'cities'])
                    ->when($request->search, fn ($q) => $q->byName($request->search))
                    ->when($request->filled('status'), function ($q) use ($request) {
                        $request->status === 'active'
                            ? $q->where('is_active', true)
                            : $q->where('is_active', false);
                    })
                    ->orderBy($request->get('sort', 'name'), $request->get('dir', 'asc'))
                    ->paginate(10)
                    ->withQueryString();
            }
        );

        return view('country.index', compact('countries'));
    }

    public function create()
    {
        return view('country.create');
    }

    public function store(StoreCountryRequest $request)
    {
        Country::create($request->validated());

        $this->bumpCache('countries');

        return redirect()->route('countries.index')
            ->with('success', 'Country added successfully!');
    }

    public function edit(Country $country)
    {
        return view('country.edit', compact('country'));
    }

    public function update(UpdateCountryRequest $request, Country $country)
    {
        $country->update($request->validated());

        $this->bumpCache('countries');

        return redirect()->route('countries.index')
            ->with('success', 'Country updated successfully!');
    }

    public function destroy(Country $country)
    {
        $country->delete();

        $this->bumpCache('countries');

        return redirect()->route('countries.index')
            ->with('success', 'Country deleted successfully!');
    }

    public function export()
    {
        $fileName = 'countries.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID',
                'Country Name',
                'ISO Code',
                'Capital',
                'Currency',
                'Total States',
                'Total Cities',
                'Status',
                'Created At',
            ]);

            $countries = Country::withCount(['states', 'cities'])->get();

            foreach ($countries as $country) {
                fputcsv($file, [
                    $country->id,
                    $country->name,
                    $country->iso_code,
                    $country->capital,
                    $country->currency,
                    $country->states_count,
                    $country->cities_count,
                    $country->is_active ? 'Active' : 'Inactive',
                    $country->created_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
