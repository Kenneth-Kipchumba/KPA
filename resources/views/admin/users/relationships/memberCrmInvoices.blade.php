<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">{{ trans('cruds.crmInvoice.title') }}</div>
            <div class="col-md-6 text-right d-print-none">
                @can('crm_invoice_create')
                <a class="btn btn-success" href="{{ route('admin.crm-invoices.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.crmInvoice.title_singular') }}</a>
                @endcan
            </div>
        </div>
    </div>

    <div class="card-body list">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-memberCrmInvoices">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.crmInvoice.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmInvoice.fields.date') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmInvoice.fields.invoice_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmInvoice.fields.member') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmInvoice.fields.rate') }}
                        </th>
                        <th>
                            {{ trans('cruds.rate.fields.price') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmInvoice.fields.amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmInvoice.fields.paid') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmInvoice.fields.balance') }}
                        </th>
                        <th>
                            {{ trans('cruds.crmInvoice.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($crmInvoices as $key => $crmInvoice)
                        <tr data-entry-id="{{ $crmInvoice->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $crmInvoice->id ?? '' }}
                            </td>
                            <td>
                                {{ $crmInvoice->date ?? '' }}
                            </td>
                            <td>
                                {{ $crmInvoice->invoice_no ?? '' }}
                            </td>
                            <td>
                                {{ $crmInvoice->member->name ?? '' }}
                            </td>
                            <td>
                                {{ $crmInvoice->rate->name ?? '' }}
                            </td>
                            <td>
                                {{ $crmInvoice->rate->price ?? '' }}
                            </td>
                            <td>
                                {{ $crmInvoice->amount ?? '' }}
                            </td>
                            <td>
                                {{ $crmInvoice->paid ?? '' }}
                            </td>
                            <td>
                                {{ $crmInvoice->balance ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\CrmInvoice::STATUS_SELECT[$crmInvoice->status] ?? '' }}
                            </td>
                            <td>
                                @can('crm_invoice_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.crm-invoices.show', $crmInvoice->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('crm_invoice_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.crm-invoices.edit', $crmInvoice->id) }}">
                                        {{ trans('global.email') }}
                                    </a>
                                @endcan

                                @can('crm_invoice_delete')
                                    <form action="{{ route('admin.crm-invoices.destroy', $crmInvoice->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('crm_invoice_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.crm-invoices.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-memberCrmInvoices:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection