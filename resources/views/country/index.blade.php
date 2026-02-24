@extends('layout.app')

@section('content')

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Countries</h5>
        <a href="/countries/create" class="btn btn-primary btn-sm">+ Add Country</a>
    </div>

    <div class="card-body">
        @if($countries->count())
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Country Name</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($countries as $index => $country)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $country->name }}</td>
                            <td>{{ $country->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">No countries found.</p>
        @endif
    </div>
</div>

@endsection