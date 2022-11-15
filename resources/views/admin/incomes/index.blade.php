@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
            <div class="row">
                <div class="col-md-6"> {{ trans('cruds.income.title_singular') }} {{ trans('global.list') }}</div>
                <div class="col-md-6 text-right">
						Choose Year
						<select  name="year" id="year" onchange="getyear()">
                            <option value="2022" >2022 </option>
							<option value="2021" >2021 </option>
							
                            
                        </select>
						&nbsp;&nbsp;
                    @can('income_create')
                        <a class="btn btn-success" href="{{ route('admin.incomes.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.income.title_singular') }}
                        </a>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                            {{ trans('global.app_csvImport') }}
                        </button>
                        @include('csvImport.modal', ['model' => 'Income', 'route' => 'admin.incomes.parseCsvImport'])
                    @endcan
                </div>
            </div>
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Income">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.income.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.income.fields.entry_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.income.fields.receipt_no') }}
                    </th>
                    <th>
                        {{ trans('cruds.income.fields.member') }}
                    </th>
                    <th>
                        {{ trans('cruds.income.fields.amount') }}
                    </th>
                    <th>
                        {{ trans('cruds.income.fields.mode') }}
                    </th>
                    <th>
                        {{ trans('cruds.income.fields.transaction_no') }}
                    </th>
                    <th>
                    {{ trans('cruds.income.fields.member') }} {{ trans('cruds.user.fields.status') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>

var receipts;

    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('income_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.incomes.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.incomes.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'entry_date', name: 'entry_date' },
{ data: 'receipt_no', name: 'receipt_no' },
{ data: 'member_name', name: 'member.name' },
{ data: 'amount', name: 'amount' },
{ data: 'mode', name: 'mode' },
{ data: 'transaction_no', name: 'transaction_no' },
{ data: 'status', name: 'status' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  };
  let table = $('.datatable-Income').DataTable(dtOverrideGlobals);
  receipts = table;
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
	getyear();
  
});

	function getyear(){

		var year = $('#year').val();
		var serachVal = year;
		receipts
				.column(2)
				.search( serachVal)
				.draw();


	}
</script>
@endsection