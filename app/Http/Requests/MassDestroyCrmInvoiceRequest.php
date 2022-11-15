<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CrmInvoice;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCrmInvoiceRequest extends FormRequest  {





public function authorize()
{
    abort_if(Gate::denies('crm_invoice_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');




return true;
    
}
public function rules()
{
    



return [
'ids' => 'required|array',
    'ids.*' => 'exists:crm_invoices,id',
];
    
}

}