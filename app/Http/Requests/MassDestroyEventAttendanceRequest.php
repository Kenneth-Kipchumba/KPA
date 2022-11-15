<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\EventAttendance;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEventAttendanceRequest extends FormRequest  {





public function authorize()
{
    abort_if(Gate::denies('event_attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');




return true;
    
}
public function rules()
{
    



return [
'ids' => 'required|array',
    'ids.*' => 'exists:event_attendances,id',
];
    
}

}