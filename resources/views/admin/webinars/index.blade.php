@extends('layouts.admin')
@section('content')
<div style="display:none;">
@if( auth()->user()->status  == 2 || auth()->user()->status  == 8)
<h3>Recent Webinars</h3>
<div class="row">

    @foreach($webinars as $key => $webinar)

    @if($webinar->specialization_id != 22)
    <div class="col-xxl-3 col-xl-4 ">
        <div class="card">
            <div class="card-header">
                
            <a class="header_black" href="{{ route("admin.specializations.show", $webinar->specialization->id ?? '' ) }}"><h6><strong>{{ $webinar->specialization->name ?? '' }}</strong></h6></a>
            <a class="header" href="{{ route("admin.webinars.show",$webinar->id) }}"><h4>{{ $webinar->title }}</h4></a>
                
                <h6>{{ date('l, d F Y, h:i A' ,strtotime($webinar->date_time))  }}</h6>
               
            </div>
            <div class="card-body p-0">
                
            <a href="{{ route("admin.webinars.show",$webinar->id) }}"><img src="{{ $webinar->image->url }}" width="100%" /></a>
            
            <div class="p-3">
                {!! $webinar->description !!}
            </div>
            </div>
        </div>
    </div>
    @endif

    @endforeach

</div>


<div class="row">
    
    @foreach($webinars as $key => $webinar)

    @if($webinar->specialization_id == 22)
	<br/><br/>
	<h3>ECD (Early Childhood Development) Resources</h3>
    <div class="col-xxl-3 col-xl-4 ">
        <div class="card">
            <div class="card-header">
                
            <a class="header_black" href="{{ route("admin.specializations.show", $webinar->specialization->id ?? '' ) }}"><h6><strong>{{ $webinar->specialization->name ?? '' }}</strong></h6></a>
            <a class="header" href="{{ route("admin.webinars.show",$webinar->id) }}"><h4>{{ $webinar->title }}</h4></a>
                
                <h6>{{ date('l, d F Y, h:i A' ,strtotime($webinar->date_time))  }}</h6>
               
            </div>
            <div class="card-body p-0">
                
            <a href="{{ route("admin.webinars.show",$webinar->id) }}"><img src="{{ $webinar->image->url }}" width="100%" /></a>
            
            <div class="p-3">
                {!! $webinar->description !!}
            </div>
            </div>
        </div>
    </div>
    @endif

    @endforeach

</div>
@endif
</div>

<div class="card" >
    <div class="card-header">
        <div class="row">
            <div class="col-md-6"> {{ trans('cruds.webinar.title') }}  </div>
            <div class="col-md-6 text-right">
                @can('webinar_create')
                <a class="btn btn-success" href="{{ route('admin.webinars.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.webinar.title_singular') }}
                </a>
                <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                    {{ trans('global.app_csvImport') }}
                </button>
                @include('csvImport.modal', ['model' => 'Webinar', 'route' => 'admin.webinars.parseCsvImport'])
                @endcan
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Webinar">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th  width="10">
                        {{ trans('cruds.webinar.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.webinar.fields.date_time') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                    <th>
                        {{ trans('cruds.webinar.fields.title') }}
                    </th>
                    <th>
                        {{ trans('cruds.webinar.fields.specialization') }}
                    </th>
                    <th>
                        {{ trans('cruds.webinar.fields.image') }}
                    </th>
                    
                </tr>
                <tr>
                    <td>
                    </td>
                   
                    <td>
                        
                    </td>
                    
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($specializations as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
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
@can('webinar_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.webinars.massDestroy') }}",
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
    ajax: "{{ route('admin.webinars.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'date_time', name: 'date_time' },

{ data: 'image', name: 'image', sortable: false, searchable: false },
{ data: 'title', name: 'title' },
{ data: 'specialization_name', name: 'specialization.name' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  };
  let table = $('.datatable-Webinar').DataTable(dtOverrideGlobals);
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