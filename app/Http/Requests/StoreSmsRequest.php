<?php

namespace App\Http\Requests;

use App\Models\Sms;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSmsRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sms_create');
    }

    public function rules()
    {
        return [
            'list' => [
                'required',
            ],
            'message' => [
                'required',
            ],
        ];
    }
}
