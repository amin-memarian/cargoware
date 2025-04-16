<?php

namespace App\Http\Requests\Airline;

use Illuminate\Foundation\Http\FormRequest;

class EditAirlineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'nullable|min:2|max:150',
            'ROE'=>'required|numeric',
            'Sale_rate' => 'numeric|nullable',
            'media_file_id' => 'numeric|nullable',
            'awa' => 'numeric|nullable',
            'awb' => 'numeric|nullable',
            'awc' => 'numeric|nullable',
            'scc' => 'numeric|nullable',
            'min_scc' => 'numeric|nullable',
            'tvc' => 'numeric|nullable',
            'hxc' => 'numeric|nullable',
            'ata' => 'numeric|nullable',
            'min_ata' => 'numeric|nullable',
            'max_ata' => 'numeric|nullable',
            'tdc' => 'numeric|nullable',
            'cgc' => 'numeric|nullable',
            'mcc' => 'numeric|nullable',
            'inc' => 'numeric|nullable',
            'mma' => 'numeric|nullable',
            'myc' => 'numeric|nullable',
            'fec' => 'numeric|nullable',
            'xdc' => 'numeric|nullable',

        ];
    }
}
