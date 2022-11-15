@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">

        
        <a href="{{ route('admin.users.show', $crmInvoice->member->id) }}"><h2><strong>  {{ $crmInvoice->invoice_no  }}</strong>  &nbsp;/&nbsp;  <strong>{{ $crmInvoice->member->name ?? '' }}</strong></h2></a>


        <a class="btn btn-default   mfs-auto mfe-1 d-print-none" href="{{ url()->previous() }}">
            {{ trans('global.back') }} 
        </a>
        @can('crm_invoice_create')
        <a class="btn btn-success mfe-1" href="{{ route('admin.crm-invoices.create') }}">
            {{ trans('global.add') }} {{ trans('cruds.crmInvoice.title_singular') }}
        </a>
        @endcan
        <a class='btn btn-info' href='{{ $crmInvoice->description ?? '' }}'>Download</a>

   </div>
    <div class="card-body">
        <div id="pdf-viewer"></div>
    </div>
</div>

<div class="nav-tabs-boxed nav-tabs-boxed-left">
    <ul class="nav nav-tabs col-md-2 p-0" role="tablist" id="relationship-tabs">
        <li class="nav-item ">
            <a class="nav-link active" href="#invoice_incomes" role="tab" data-toggle="tab">
                {{ trans('cruds.income.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content col-md-10 p-0 b-none">
        <div class="tab-pan active" role="tabpanel" id="invoice_incomes">
            @includeIf('admin.crmInvoices.relationships.invoiceIncomes', ['incomes' => $crmInvoice->invoiceIncomes])
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
    $( document ).ready(function() {
        document.title = "KPA - {{ trans('cruds.crmInvoice.title_singular') }} -  {{ $crmInvoice->invoice_no }}";
    });

    PDFObject.embed("{{ $crmInvoice->file ?? '' }}", "#pdf-viewer");

</script>
@endsection
