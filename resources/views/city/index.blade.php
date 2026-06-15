@extends('layout.app')

@section('content')

<div class="card shadow border-0">

    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">

        <h4 class="mb-0">🏙 Cities Management</h4>

        <a href="{{ route('cities.create') }}"
            class="btn btn-light btn-sm fw-bold">

            + Add City

        </a>

    </div>

    <div class="card-body">

        <form method="GET" class="row g-2 mb-4">

            <div class="col-md-5">
                <input type="text"
                    name="search"
                    class="form-control"
                    placeholder="🔍 Search City / Country..."
                    value="{{ request('search') }}">
            </div>

            <div class="col-md-4">
                <select name="country_id" class="form-select">

                    <option value="">🌍 All Countries</option>

                    @foreach($countries as $country)

                    <option value="{{ $country->id }}"
                        {{ request('country_id') == $country->id ? 'selected' : '' }}>

                        {{ $country->name }}

                    </option>

                    @endforeach

                </select>
            </div>

            <div class="col-md-3">
                <button class="btn btn-success w-100">
                    Filter
                </button>
            </div>

        </form>

        @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button class="btn-close"
                data-bs-dismiss="alert"></button>

        </div>

        @endif

        @if($cities->count())

        <div class="table-responsive">

            <table class="table table-hover table-bordered align-middle">

                <thead class="table-dark text-center">

                    <tr>
                        <th>#</th>
                        <th>City Name</th>
                        <th>Country</th>
                        <th>Created Date</th>
                        <th width="120">Action</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($cities as $index => $city)

                    <tr>

                        <td class="text-center">
                            {{ $cities->firstItem() + $index }}
                        </td>

                        <td>
                            <strong>{{ $city->name }}</strong>
                        </td>

                        <td class="text-center">

                            <span class="badge bg-info text-dark fs-6">

                                {{ $city->country->name }}

                            </span>

                        </td>

                        <td>
                            {{ $city->created_at->format('d M Y') }}
                        </td>

                        <td class="text-center">

                            <form action="{{ route('cities.destroy',$city->id) }}"
                                method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    onclick="return confirm('Delete this city?')"
                                    class="btn btn-danger btn-sm">

                                    🗑 Delete

                                </button>

                            </form>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $cities->links('pagination::bootstrap-5') }}
        </div>

        @else

        <div class="alert alert-warning text-center">
            No cities found.
        </div>

        @endif

    </div>

</div>

@endsection