<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\QuestionOption;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyQuestionOptionRequest extends FormRequest  {





public function authorize()
{
    abort_if(Gate::denies('question_option_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');




return true;
    
}
public function rules()
{
    



return [
'ids' => 'required|array',
    'ids.*' => 'exists:question_options,id',
];
    
}

}