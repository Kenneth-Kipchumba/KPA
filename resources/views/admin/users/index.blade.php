@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
            <div class="row">
                <div class="col-md-6"> {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }} </div>
                <div class="col-md-6 text-right">
                    @can('user_create')
                        <a class="btn btn-success" href="{{ route('admin.users.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
                        </a>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                            {{ trans('global.app_csvImport') }}
                        </button>
                        @include('csvImport.modal', ['model' => 'User', 'route' => 'admin.users.parseCsvImport'])
                    @endcan
                </div>
            </div>
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-User">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                   
                    <th>
                        {{ trans('cruds.user.fields.member_no') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.phone') }}
                    </th>
                  
                    <th>
                        {{ trans('cruds.user.fields.specialization') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.location') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.status') }}
                    </th>
                    <th class="d-none">
                        {{ trans('cruds.user.fields.id') }}
                    </th>
                
                    <th class="d-none">
                        {{ trans('cruds.user.fields.designation') }}
                    </th>
                    <th class="d-none">
                        {{ trans('cruds.user.fields.board_reg_no') }}
                    </th>

                    <th class="d-none">
                        {{ trans('cruds.user.fields.specialization_other') }}
                    </th>
                    <th  class="d-none">
                        {{ trans('cruds.user.fields.workstation') }}
                    </th>
                    <th class="d-none">
                        {{ trans('cruds.user.fields.address') }}
                    </th>
                    <th class="d-none">
                        {{ trans('cruds.user.fields.id_no') }}
                    </th>
                    
                    <th class="d-none">
                        {{ trans('cruds.user.fields.postal_address') }}
                    </th>
                    <th class="d-none">
                        {{ trans('cruds.user.fields.postal_code') }}
                    </th>
                    <th class="d-none">
                        {{ trans('cruds.user.fields.date_registration') }}
                    </th>
                    <th class="d-none">
                        {{ trans('cruds.user.fields.approved') }}
                    </th>
                    <th class="d-none">
                        {{ trans('cruds.user.fields.roles') }}
                    </th>
                   
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <input style="max-width:50px;" class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td style="min-width:190px !important;">
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input style="max-width:100px;" class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                   
                   
                    <td>
                        <select style="max-width:80px;" class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($specializations as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select style="max-width:80px;" class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($locations as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\User::STATUS_SELECT as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="d-none" >
                        <select style="max-width:100px;" class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\User::DESIGNATION_SELECT as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="d-none">
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td class="d-none">
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td class="d-none">
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td class="d-none">
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td class="d-none">
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    
                    <td class="d-none">
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td class="d-none">
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td class="d-none">
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td class="d-none">
                    </td>
                    <td class="d-none">
                    </td>
                    <td class="d-none">
                        
                    </td>
                    <td>
                    </td>
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
@can('user_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text:  '<i class="far fa-trash-alt"></i>',
    url: "{{ route('admin.users.massDestroy') }}",
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
    ajax: "{{ route('admin.users.index') }}",
    columns: [
        { data: 'placeholder', name: 'placeholder' },
        
        { data: 'member_no', name: 'member_no' },
        { data: 'name', name: 'name' },
        { data: 'email', name: 'email' },
        { data: 'phone', name: 'phone' },
        { data: 'specialization_name', name: 'specialization.name' },
        { data: 'location_name', name: 'location.name' },
        { data: 'status', name: 'status' },
        { data: 'id', name: 'id', visible: false },
        
        { data: 'designation', name: 'designation', className: "none"  },
        { data: 'board_reg_no', name: 'board_reg_no' , className: "none" },
        { data: 'specialization_other', name: 'specialization_other', className: "none" },
        { data: 'workstation', name: 'workstation' , className: "none" },
        { data: 'address', name: 'address' , className: "none" }, 
        { data: 'id_no', name: 'id_no' , className: "none" },
        { data: 'postal_address', name: 'postal_address' , className: "none" },
        { data: 'postal_code', name: 'postal_code' , className: "none" },
        { data: 'date_registration', name: 'date_registration' , className: "none" },
        { data: 'approved', name: 'approved' , className: "none" },
        { data: 'roles', name: 'roles.title' , className: "none" },
        { data: 'actions', name: '{{ trans('global.actions') }}' , className: "none" },
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  };
  let table = $('.datatable-User').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
let visibleColumnsIndexes = null;
$('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value

      let index = $(this).parent().index()
      if (visibleColumnsIndexes !== null) {
        index = visibleColumnsIndexes[index]
      }

      table
        .column(index)
        .search(value, strict)
        .draw()
  });
table.on('column-visibility.dt', function(e, settings, column, state) {
      visibleColumnsIndexes = []
      table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
      });
  })
});

</script>
@endsection