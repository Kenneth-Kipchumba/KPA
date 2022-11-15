<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCrmInvoiceRequest;
use App\Http\Requests\UpdateCrmInvoiceRequest;
use App\Http\Resources\Admin\CrmInvoiceResource;
use App\Models\CrmInvoice;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CrmInvoiceApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('crm_invoice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrmInvoiceResource(CrmInvoice::with(['member', 'rate'])->get());
    }

    public function store(StoreCrmInvoiceRequest $request)
    {
        $crmInvoice = CrmInvoice::create($request->all());

        return (new CrmInvoiceResource($crmInvoice))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CrmInvoice $crmInvoice)
    {
        abort_if(Gate::denies('crm_invoice_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrmInvoiceResource($crmInvoice->load(['member', 'rate']));
    }

    public function update(UpdateCrmInvoiceRequest $request, CrmInvoice $crmInvoice)
    {
        $crmInvoice->update($request->all());

        return (new CrmInvoiceResource($crmInvoice))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CrmInvoice $crmInvoice)
    {
        abort_if(Gate::denies('crm_invoice_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crmInvoice->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
