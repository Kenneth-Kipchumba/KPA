@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
            <div class="row">
                <div class="col-md-6"> {{ trans('cruds.email.title_singular') }} {{ trans('global.list') }} </div>
                <div class="col-md-6 text-right">
                    @can('email_create')
                        <a class="btn btn-success" href="{{ route('admin.emails.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.email.title_singular') }}
                        </a>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                            {{ trans('global.app_csvImport') }}
                        </button>
                        @include('csvImport.modal', ['model' => 'Email', 'route' => 'admin.emails.parseCsvImport'])
                    @endcan
                </div>
            </div>
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Email">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th class="d-none">
                        {{ trans('cruds.email.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.email.fields.date') }}
                    </th>
                   
                    <th>
                        {{ trans('cruds.email.fields.image') }}
                    </th>
                  
                    <th>
                        {{ trans('cruds.email.fields.subject') }}
                    </th>
                    <th>
                        {{ trans('cruds.email.fields.list') }}
                    </th>
                    <th class="d-none">
                        {{ trans('cruds.email.fields.message') }}
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
@can('email_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.emails.massDestroy') }}",
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
    ajax: "{{ route('admin.emails.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id',  visible: false },
{ data: 'created_at', name: 'created_at' },
{ data: 'image', name: 'image', sortable: false, searchable: false },
{ data: 'subject', name: 'subject' },
{ data: 'list', name: 'list' },
{ data: 'message', name: 'message', className: "none"  },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  };
  let table = $('.datatable-Email').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection