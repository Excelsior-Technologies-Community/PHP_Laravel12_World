<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('state')->id;

        return [
            'country_id' => 'required|exists:countries,id',
            'name'       => 'required|string|max:255|unique:states,name,' . $id . ',id,country_id,' . $this->country_id,
            'is_active'  => 'nullable|boolean',
        ];
    }
}
