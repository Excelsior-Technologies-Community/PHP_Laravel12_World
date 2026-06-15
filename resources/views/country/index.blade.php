@extends('layout.app')

@section('content')

<div class="card shadow border-0">

    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

        <h4 class="mb-0">🌍 Countries Management</h4>

        <div>
            <a href="{{ route('countries.export') }}"
                class="btn btn-success btn-sm">
                📥 Export CSV
            </a>

            <a href="{{ route('countries.create') }}"
                class="btn btn-light btn-sm">
                + Add Country
            </a>
        </div>

    </div>

    <div class="card-body">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>
            </div>
        @endif

        {{-- Search --}}
        <form method="GET" class="row g-2 mb-4">

            <div class="col-md-10">
                <input type="text"
                    name="search"
                    class="form-control"
                    placeholder="🔍 Search Country..."
                    value="{{ request('search') }}">
            </div>

            <div class="col-md-2">
                <button type="submit"
                    class="btn btn-primary w-100">
                    Search
                </button>
            </div>

        </form>

        @if($countries->count())

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark text-center">

                        <tr>
                            <th>#</th>
                            <th>Country Name</th>
                            <th>Total Cities</th>
                            <th>Created Date</th>
                            <th width="140">Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($countries as $index => $country)

                            <tr>

                                <td class="text-center">
                                    {{ $countries->firstItem() + $index }}
                                </td>

                                <td>
                                    <strong>{{ $country->name }}</strong>
                                </td>

                                <td class="text-center">

                                    <span class="badge bg-success">
                                        {{ $country->cities_count }}
                                    </span>

                                </td>

                                <td>
                                    {{ $country->created_at->format('d M Y') }}
                                </td>

                                <td class="text-center">

                                    <form action="{{ route('countries.destroy', $country->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this country?')">

                                            🗑 Delete

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">

                <div class="shadow-sm p-2 bg-white rounded">

                    {{ $countries->links('pagination::bootstrap-5') }}

                </div>

            </div>

        @else

            <div class="alert alert-warning text-center">

                No countries found.

            </div>

        @endif

    </div>

</div>

@endsection