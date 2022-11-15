<?php

namespace App\Http\Requests;

use App\Models\Email;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEmailRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('email_edit');
    }

    public function rules()
    {
        return [
            'list' => [
                'required',
            ],
            'subject' => [
                'string',
                'required',
            ],
            'message' => [
                'required',
            ],
        ];
    }
}
