<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('city')->id;

        return [
            'state_id'   => 'required|exists:states,id',
            'country_id' => 'required|exists:countries,id',
            'name'       => 'required|string|max:255|unique:cities,name,' . $id . ',id,state_id,' . $this->state_id,
            'is_active'  => 'nullable|boolean',
        ];
    }
}
