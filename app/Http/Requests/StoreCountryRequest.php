<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255|unique:countries,name',
            'iso_code'  => 'nullable|string|max:3',
            'currency'  => 'nullable|string|max:10',
            'capital'   => 'nullable|string|max:255',
            'flag'      => 'nullable|string|max:10',
            'is_active' => 'nullable|boolean',
        ];
    }
}
