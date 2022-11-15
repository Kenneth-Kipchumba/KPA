<?php

namespace App\Http\Requests;

use App\Models\EventAttendance;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEventAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('event_attendance_edit');
    }

    public function rules()
    {
        return [
            'dates' => [
                'string',
                'nullable',
            ],
            'receipt_no' => [
                'string',
                'nullable',
            ],
        ];
    }
}
