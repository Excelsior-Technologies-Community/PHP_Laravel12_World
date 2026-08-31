@extends('layout.app')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('countries.index') }}">Countries</a></li>
        <li class="breadcrumb-item active">Edit Country</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header"><h5 class="mb-0">✏ Edit Country</h5></div>
            <div class="card-body">
                <form method="POST" action="{{ route('countries.update', $country->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Country Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $country->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">ISO Code</label>
                            <input type="text" name="iso_code" maxlength="3"
                                class="form-control @error('iso_code') is-invalid @enderror"
                                value="{{ old('iso_code', $country->iso_code) }}">
                            @error('iso_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Capital</label>
                            <input type="text" name="capital"
                                class="form-control @error('capital') is-invalid @enderror"
                                value="{{ old('capital', $country->capital) }}">
                            @error('capital')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Currency</label>
                            <input type="text" name="currency"
                                class="form-control @error('currency') is-invalid @enderror"
                                value="{{ old('currency', $country->currency) }}">
                            @error('currency')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Flag (emoji)</label>
                        <input type="text" name="flag"
                            class="form-control @error('flag') is-invalid @enderror"
                            value="{{ old('flag', $country->flag) }}">
                        @error('flag')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1"
                            {{ old('is_active', $country->is_active) ? 'checked' : '' }} id="activeSwitch">
                        <label class="form-check-label" for="activeSwitch">Active</label>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('countries.index') }}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
