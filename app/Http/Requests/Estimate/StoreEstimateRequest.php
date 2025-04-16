<?php

namespace App\Http\Requests\Estimate;

use Illuminate\Foundation\Http\FormRequest;

class StoreEstimateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'nullable',
                'required_if:user_exist,no',
                'string'
            ],
            'lastname' => [
                'nullable',
                'required_if:user_exist,no',
                'string'
            ],
            'mobile' => [
                'nullable',
                'required_if:user_exist,no',
                'regex:/^09[0-9]{9}$/',
                'unique:users,mobile',
                'size:11'
            ],
            'user_id' => [
                'required_if:user_exist,yes'
            ],
            'partners' => [
                'required_if:partners_exist,yes'
            ]

        ];
    }
}
