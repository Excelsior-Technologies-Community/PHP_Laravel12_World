@extends('layout.app')

@section('content')

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Countries</h5>
        <a href="/countries/create" class="btn btn-primary btn-sm">+ Add Country</a>
    </div>

    <div class="card-body">

        {{-- SEARCH --}}
        <form method="GET" class="mb-3">
            <input type="text"
                name="search"
                class="form-control"
                placeholder="Search country..."
                value="{{ request('search') }}">
        </form>

        @if($countries->count())
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Country Name</th>
                    <th>Total Cities</th>
                    <th>Created At</th>
                </tr>
            </thead>

            <tbody>
                @foreach($countries as $index => $country)
                <tr>
                    <td>{{ $countries->firstItem() + $index }}</td>
                    <td>{{ $country->name }}</td>
                    <td>
                        <span class="badge bg-success">
                            {{ $country->cities_count }}
                        </span>
                    </td>
                    <td>{{ $country->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-center mt-4">
            <div class="shadow-sm p-2 bg-white rounded">
                {{ $countries->links('pagination::bootstrap-5') }}
            </div>
        </div>

        @else
        <p class="text-muted">No countries found.</p>
        @endif

    </div>
</div>

@endsection