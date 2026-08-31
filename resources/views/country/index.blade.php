@extends('layout.app')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Countries</li>
    </ol>
</nav>

<div class="card shadow border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h4 class="mb-0">🌍 Countries Management</h4>

        <div>
            <a href="{{ route('countries.export') }}" class="btn btn-success btn-sm">📥 Export CSV</a>
            <a href="{{ route('countries.create') }}" class="btn btn-light btn-sm">+ Add Country</a>
        </div>
    </div>

    <div class="card-body">

        {{-- Filters --}}
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control"
                    placeholder="🔍 Search Country..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('countries.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>

        @if($countries->count())
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>
                                <a class="text-white text-decoration-none" href="{{ route('countries.index', array_merge(request()->except('page'), ['sort' => 'name', 'dir' => request('dir') == 'asc' ? 'desc' : 'asc'])) }}">
                                    Country @if(request('sort') == 'name'){{ request('dir') == 'asc' ? '▲' : '▼' }}@endif
                                </a>
                            </th>
                            <th>ISO</th>
                            <th>Capital</th>
                            <th>Currency</th>
                            <th>States</th>
                            <th>Cities</th>
                            <th>Status</th>
                            <th width="160">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($countries as $index => $country)
                            <tr>
                                <td class="text-center">{{ $countries->firstItem() + $index }}</td>
                                <td>
                                    <span class="flag-emoji">{{ $country->flag ?: '🏳️' }}</span>
                                    <strong>{{ $country->name }}</strong>
                                </td>
                                <td class="text-center">{{ $country->iso_code ? strtoupper($country->iso_code) : '-' }}</td>
                                <td>{{ $country->capital ?: '-' }}</td>
                                <td>{{ $country->currency ?: '-' }}</td>
                                <td class="text-center">
                                    <span class="badge bg-info text-dark">{{ $country->states_count }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success">{{ $country->cities_count }}</span>
                                </td>
                                <td class="text-center">
                                    @if($country->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('countries.edit', $country->id) }}" class="btn btn-warning btn-sm">✏ Edit</a>
                                    <form action="{{ route('countries.destroy', $country->id) }}" method="POST" class="d-inline form-delete">
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
                {{ $countries->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="alert alert-warning text-center">No countries found.</div>
        @endif

    </div>
</div>

@endsection
