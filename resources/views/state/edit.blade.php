@extends('layout.app')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('states.index') }}">States</a></li>
        <li class="breadcrumb-item active">Edit State</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header"><h5 class="mb-0">✏ Edit State / Province</h5></div>
            <div class="card-body">
                <form method="POST" action="{{ route('states.update', $state->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Select Country <span class="text-danger">*</span></label>
                        <select name="country_id" class="form-select @error('country_id') is-invalid @enderror" required>
                            <option value="">-- Select Country --</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}"
                                    {{ old('country_id', $state->country_id) == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('country_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">State / Province Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $state->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1"
                            {{ old('is_active', $state->is_active) ? 'checked' : '' }} id="activeSwitch">
                        <label class="form-check-label" for="activeSwitch">Active</label>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('states.index') }}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
