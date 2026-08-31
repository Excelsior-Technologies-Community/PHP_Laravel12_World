@extends('layout.app')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('countries.index') }}">Countries</a></li>
        <li class="breadcrumb-item active">Cities</li>
    </ol>
</nav>

<div class="card shadow border-0">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">🏙 Cities Management</h4>
        <a href="{{ route('cities.create') }}" class="btn btn-light btn-sm fw-bold">+ Add City</a>
    </div>

    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control"
                    placeholder="🔍 Search City / State / Country..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="country_id" id="filter_country_id" class="form-select"
                    data-country-select="#filter_state_id">
                    <option value="">🌍 All Countries</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ old('country_id', request('country_id')) == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="state_id" id="filter_state_id" class="form-select"
                    data-selected-state="{{ old('state_id', request('state_id')) }}">
                    <option value="">🗺 All States</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success w-100">Filter</button>
            </div>
        </form>

        @if($cities->count())
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Country</th>
                            <th>Status</th>
                            <th width="140">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cities as $index => $city)
                            <tr>
                                <td class="text-center">{{ $cities->firstItem() + $index }}</td>
                                <td><strong>{{ $city->name }}</strong></td>
                                <td>{{ $city->state->name }}</td>
                                <td>
                                    <span class="flag-emoji">{{ $city->country->flag ?: '🏳️' }}</span>
                                    {{ $city->country->name }}
                                </td>
                                <td class="text-center">
                                    @if($city->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('cities.edit', $city->id) }}" class="btn btn-warning btn-sm">✏ Edit</a>
                                    <form action="{{ route('cities.destroy', $city->id) }}" method="POST" class="d-inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">🗑 Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $cities->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="alert alert-warning text-center">No cities found.</div>
        @endif
    </div>
</div>

@endsection
