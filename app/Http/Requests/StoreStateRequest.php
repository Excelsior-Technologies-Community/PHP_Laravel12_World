<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'country_id' => 'required|exists:countries,id',
            'name'       => 'required|string|max:255|unique:states,name,NULL,id,country_id,' . $this->country_id,
            'is_active'  => 'nullable|boolean',
        ];
    }
}
