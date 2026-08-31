@extends('layout.app')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('cities.index') }}">Cities</a></li>
        <li class="breadcrumb-item active">Edit City</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header"><h5 class="mb-0">✏ Edit City</h5></div>
            <div class="card-body">
                <form method="POST" action="{{ route('cities.update', $city->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Select Country <span class="text-danger">*</span></label>
                        <select name="country_id" id="country_id" class="form-select @error('country_id') is-invalid @enderror"
                            data-country-select="#state_id" required>
                            <option value="">-- Select Country --</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}"
                                    {{ old('country_id', $city->country_id) == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('country_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select State <span class="text-danger">*</span></label>
                        <select name="state_id" id="state_id" class="form-select @error('state_id') is-invalid @enderror"
                            data-selected-state="{{ old('state_id', $city->state_id) }}" required>
                            <option value="">-- Select State --</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}"
                                    {{ old('state_id', $city->state_id) == $state->id ? 'selected' : '' }}>
                                    {{ $state->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('state_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">City Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $city->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1"
                            {{ old('is_active', $city->is_active) ? 'checked' : '' }} id="activeSwitch">
                        <label class="form-check-label" for="activeSwitch">Active</label>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('cities.index') }}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
