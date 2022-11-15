<?php

namespace App\Http\Requests;

use App\Models\CrmInvoice;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCrmInvoiceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('crm_invoice_create');
    }

    public function rules()
    {
        return [
            'date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'invoice_no' => [
                'string',
                'required',
                'unique:crm_invoices',
            ],
            'amount' => [
                'numeric',
                'required',
                'min:0',
            ],
            'paid' => [
                'numeric',
                'required',
                'min:0',
            ],
            'balance' => [
                'numeric',
            ],
            'discount' => [
                'numeric',
                'min:0',
            ],
            'status' => [
                'required',
            ],
        ];
    }
}
