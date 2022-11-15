@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.rate.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.rates.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.rate.fields.id') }}
                        </th>
                        <td>
                            {{ $rate->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rate.fields.name') }}
                        </th>
                        <td>
                            {{ $rate->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rate.fields.price') }}
                        </th>
                        <td>
                            {{ $rate->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rate.fields.description') }}
                        </th>
                        <td>
                            {!! $rate->description !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.rates.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#rate_crm_invoices" role="tab" data-toggle="tab">
                {{ trans('cruds.crmInvoice.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="rate_crm_invoices">
            @includeIf('admin.rates.relationships.rateCrmInvoices', ['crmInvoices' => $rate->rateCrmInvoices])
        </div>
    </div>
</div>

@endsection