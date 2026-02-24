@extends('layout.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-sm">
            <div class="card-header">
                <h5>Add Country</h5>
            </div>

            <div class="card-body">
                <form method="POST" action="/countries">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Country Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="/countries" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection