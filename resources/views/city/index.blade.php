@extends('layout.app')

@section('content')

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Cities</h5>
        <a href="/cities/create" class="btn btn-primary btn-sm">+ Add City</a>
    </div>

    <div class="card-body">

        {{-- SEARCH --}}
        <form method="GET" class="mb-3">
            <input type="text"
                name="search"
                class="form-control"
                placeholder="Search city or country..."
                value="{{ request('search') }}">
        </form>

        @if($cities->count())
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>City Name</th>
                    <th>Country</th>
                    <th>Created At</th>
                </tr>
            </thead>

            <tbody>
                @foreach($cities as $index => $city)
                <tr>
                    <td>{{ $cities->firstItem() + $index }}</td>
                    <td>{{ $city->name }}</td>
                    <td>
                        <span class="badge bg-info text-dark">
                            {{ $city->country->name }}
                        </span>
                    </td>
                    <td>{{ $city->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-center mt-4">
            <div class="shadow-sm p-2 bg-white rounded">
                {{ $cities->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @else
        <p class="text-muted">No cities found.</p>
        @endif

    </div>
</div>

@endsection