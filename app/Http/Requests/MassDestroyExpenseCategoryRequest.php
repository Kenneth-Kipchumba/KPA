<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ExpenseCategory;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyExpenseCategoryRequest extends FormRequest  {





public function authorize()
{
    abort_if(Gate::denies('expense_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');




return true;
    
}
public function rules()
{
    



return [
'ids' => 'required|array',
    'ids.*' => 'exists:expense_categories,id',
];
    
}

}