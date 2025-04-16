<?php

namespace App\Http\Requests\Loads;

use Illuminate\Foundation\Http\FormRequest;

class LoadsStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'store' => 'required',
            'destination' => 'required',
            'weight' => 'required',
        ];
    }
}
