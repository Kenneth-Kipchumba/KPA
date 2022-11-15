<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_edit');
    }

    public function rules()
    {
        return [
            'member_no' => [
                'string',
                'nullable',
            ],
            'name' => [
                'string',
                'required',
                'unique:users,name,' . request()->route('user')->id,
            ],
            'email' => [
                'required',
                'unique:users,email,' . request()->route('user')->id,
            ],
            'phone' => [
                'string',
                'required',
                'unique:users,phone,' . request()->route('user')->id,
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
            'latitude' => [
                'string',
                'nullable',
            ],
            'longitude' => [
                'string',
                'nullable',
            ],
        ];
    }
}
