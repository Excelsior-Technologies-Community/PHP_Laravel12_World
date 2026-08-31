<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Http\Controllers\Concerns\CacheVersioning;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class CityController extends Controller
{
    use CacheVersioning;

    public function index(Request $request)
    {
        $countries = Country::orderBy('name')->get();

        $cities = Cache::remember(
            $this->cacheKey($request, 'cities'),
            now()->addMinutes(10),
            function () use ($request) {
                return City::with(['state', 'country'])
                    ->when($request->search, function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->search . '%')
                            ->orWhereHas('state', fn ($q) => $q->where('name', 'like', '%' . $request->search . '%'))
                            ->orWhereHas('country', fn ($q) => $q->where('name', 'like', '%' . $request->search . '%'));
                    })
                    ->when($request->country_id, fn ($q) => $q->where('country_id', $request->country_id))
                    ->when($request->state_id, fn ($q) => $q->where('state_id', $request->state_id))
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

        session()->flashInput($request->only(['country_id', 'state_id']));

        return view('city.index', compact('cities', 'countries'));
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();

        return view('city.create', compact('countries'));
    }

    public function store(StoreCityRequest $request)
    {
        City::create($request->validated());

        $this->bumpCache('cities', 'states');

        return redirect()->route('cities.index')
            ->with('success', 'City added successfully!');
    }

    public function edit(City $city)
    {
        $countries = Country::orderBy('name')->get();
        $states    = State::where('country_id', $city->country_id)->orderBy('name')->get();

        return view('city.edit', compact('city', 'countries', 'states'));
    }

    public function update(UpdateCityRequest $request, City $city)
    {
        $city->update($request->validated());

        $this->bumpCache('cities', 'states');

        return redirect()->route('cities.index')
            ->with('success', 'City updated successfully!');
    }

    public function destroy(City $city)
    {
        $city->delete();

        $this->bumpCache('cities', 'states');

        return redirect()->route('cities.index')
            ->with('success', 'City deleted successfully!');
    }
}
