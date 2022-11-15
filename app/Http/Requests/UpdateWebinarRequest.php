<?php

namespace App\Http\Requests;

use App\Models\Webinar;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateWebinarRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('webinar_edit');
    }

    public function rules()
    {
        return [
            'date_time' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'title' => [
                'string',
                'nullable',
            ],
            'link' => [
                'string',
                'nullable',
            ],
            'video' => [
                'string',
                'nullable',
            ],
        ];
    }
}
