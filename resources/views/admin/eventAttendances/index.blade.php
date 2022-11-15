@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
            <div class="row">
                <div class="col-md-6"> {{ trans('cruds.eventAttendance.title_singular') }} {{ trans('global.list') }} </div>
                <div class="col-md-6 text-right">
                @can('event_attendance_create')
                    <a class="btn btn-success" href="{{ route('admin.event-attendances.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.eventAttendance.title_singular') }}
                    </a>
                    <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                        {{ trans('global.app_csvImport') }}
                    </button>
                    @include('csvImport.modal', ['model' => 'EventAttendance', 'route' => 'admin.event-attendances.parseCsvImport'])
                @endcan
                </div>
            </div>
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-EventAttendance">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.eventAttendance.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.eventAttendance.fields.event') }}
                    </th>
                    <th>
                        {{ trans('cruds.event.fields.category') }}
                    </th>
                    <th>
                        {{ trans('cruds.eventAttendance.fields.member') }}
                    </th>
                    <th>
                        {{ trans('cruds.eventAttendance.fields.dates') }}
                    </th>
                    <th>
                        {{ trans('cruds.eventAttendance.fields.receipt_no') }}
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
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('event_attendance_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.event-attendances.massDestroy') }}",
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
    ajax: "{{ route('admin.event-attendances.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'event_name', name: 'event.name' },
{ data: 'event.category', name: 'event.category' },
{ data: 'member_name', name: 'member.name' },
{ data: 'dates', name: 'dates' },
{ data: 'receipt_no', name: 'receipt_no' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  };
  let table = $('.datatable-EventAttendance').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection