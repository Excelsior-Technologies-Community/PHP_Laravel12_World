<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Country;
use App\Http\Requests\StoreStateRequest;
use App\Http\Requests\UpdateStateRequest;
use App\Http\Controllers\Concerns\CacheVersioning;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class StateController extends Controller
{
    use CacheVersioning;

    public function index(Request $request)
    {
        $countries = Country::orderBy('name')->get();

        $states = Cache::remember(
            $this->cacheKey($request, 'states'),
            now()->addMinutes(10),
            function () use ($request) {
                return State::with(['country', 'cities'])
                    ->when($request->search, fn ($q) => $q->byName($request->search))
                    ->when($request->country_id, fn ($q) => $q->where('country_id', $request->country_id))
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

        return view('state.index', compact('states', 'countries'));
    }

    public function create(Request $request)
    {
        $countries = Country::orderBy('name')->get();

        return view('state.create', compact('countries'));
    }

    public function store(StoreStateRequest $request)
    {
        State::create($request->validated());

        $this->bumpCache('states', 'countries');

        return redirect()->route('states.index')
            ->with('success', 'State added successfully!');
    }

    public function edit(State $state)
    {
        $countries = Country::orderBy('name')->get();

        return view('state.edit', compact('state', 'countries'));
    }

    public function update(UpdateStateRequest $request, State $state)
    {
        $state->update($request->validated());

        $this->bumpCache('states', 'countries');

        return redirect()->route('states.index')
            ->with('success', 'State updated successfully!');
    }

    public function destroy(State $state)
    {
        $state->delete();

        $this->bumpCache('states', 'countries');

        return redirect()->route('states.index')
            ->with('success', 'State deleted successfully!');
    }

    public function byCountry(Country $country)
    {
        return response()->json(
            $country->states()->orderBy('name')->get(['id', 'name'])
        );
    }
}
