<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_create');
    }

    public function rules()
    {
        return [
            'member_no' => [
                'string',
                'required',
                'unique:users',
            ],
            'name' => [
                'string',
                'required',
                'unique:users',
            ],
            'email' => [
                'required',
                'unique:users',
            ],
            'phone' => [
                'string',
                'required',
                'unique:users',
            ],
            'board_reg_no' => [
                'string',
                'nullable',
            ],
            'designation_other' => [
                'string',
                'nullable',
            ],
            'specialization_other' => [
                'string',
                'nullable',
            ],
            'workstation' => [
                'string',
                'nullable',
            ],
            'address' => [
                'string',
                'nullable',
            ],
            'id_no' => [
                'string',
                'nullable',
            ],
            'postal_address' => [
                'string',
                'nullable',
            ],
            'postal_code' => [
                'string',
                'nullable',
            ],
            'password' => [
                'required',
            ],
            'date_registration' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'roles.*' => [
                'integer',
            ],
            'roles' => [
                'required',
                'array',
            ],
        ];
    }
}
