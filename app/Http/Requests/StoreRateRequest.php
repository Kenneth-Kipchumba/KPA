<?php

namespace App\Http\Requests;

use App\Models\Rate;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('rate_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'price' => [
                'numeric',
                'required',
            ],
        ];
    }
}
