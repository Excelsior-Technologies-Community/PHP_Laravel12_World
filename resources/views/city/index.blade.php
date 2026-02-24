@extends('layout.app')

@section('content')

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Cities</h5>
        <a href="/cities/create" class="btn btn-primary btn-sm">+ Add City</a>
    </div>

    <div class="card-body">
        @if($cities->count())
            <table class="table table-bordered table-hover">
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
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $city->name }}</td>
                            <td>{{ $city->country->name }}</td>
                            <td>{{ $city->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">No cities found.</p>
        @endif
    </div>
</div>

@endsection