@extends('layout.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-sm">
            <div class="card-header">
                <h5>Add City</h5>
            </div>

            <div class="card-body">
                <form method="POST" action="/cities">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Select Country</label>
                        <select name="country_id" class="form-select" required>
                            <option value="">-- Select Country --</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">City Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="/cities" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection