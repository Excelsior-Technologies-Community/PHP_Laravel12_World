@extends('layout.app')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('countries.index') }}">Countries</a></li>
        <li class="breadcrumb-item active">States</li>
    </ol>
</nav>

<div class="card shadow border-0">
    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
        <h4 class="mb-0">🗺 States / Provinces Management</h4>
        <a href="{{ route('states.create') }}" class="btn btn-dark btn-sm">+ Add State</a>
    </div>

    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control"
                    placeholder="🔍 Search State..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="country_id" class="form-select">
                    <option value="">🌍 All Countries</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">Filter</button>
            </div>
        </form>

        @if($states->count())
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>State / Province</th>
                            <th>Country</th>
                            <th>Cities</th>
                            <th>Status</th>
                            <th width="160">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($states as $index => $state)
                            <tr>
                                <td class="text-center">{{ $states->firstItem() + $index }}</td>
                                <td><strong>{{ $state->name }}</strong></td>
                                <td>
                                    <span class="flag-emoji">{{ $state->country->flag ?: '🏳️' }}</span>
                                    {{ $state->country->name }}
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success">{{ $state->cities_count }}</span>
                                </td>
                                <td class="text-center">
                                    @if($state->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('states.edit', $state->id) }}" class="btn btn-warning btn-sm">✏ Edit</a>
                                    <form action="{{ route('states.destroy', $state->id) }}" method="POST" class="d-inline form-delete">
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
                {{ $states->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="alert alert-warning text-center">No states found.</div>
        @endif
    </div>
</div>

@endsection
