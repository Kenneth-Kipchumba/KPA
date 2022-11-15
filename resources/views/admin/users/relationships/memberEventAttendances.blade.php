<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">{{ trans('cruds.eventAttendance.title_singular') }} {{ trans('global.list') }}</div>
            <div class="col-md-6 text-right d-print-none">
                @can('event_attendance_create')
                    <a class="btn btn-success" href="{{ route('admin.event-attendances.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.eventAttendance.title_singular') }}
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="card-body list">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-memberEventAttendances">
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
                <tbody>
                    @foreach($eventAttendances as $key => $eventAttendance)
                        <tr data-entry-id="{{ $eventAttendance->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $eventAttendance->id ?? '' }}
                            </td>
                            <td>
                                {{ $eventAttendance->event->name ?? '' }}
                            </td>
                            <td>
                                @if($eventAttendance->event)
                                    {{ $eventAttendance->event::CATEGORY_SELECT[$eventAttendance->event->category] ?? '' }}
                                @endif
                            </td>
                            <td>
                                {{ $eventAttendance->member->name ?? '' }}
                            </td>
                            <td>
                                {{ $eventAttendance->dates ?? '' }}
                            </td>
                            <td>
                                {{ $eventAttendance->receipt_no ?? '' }}
                            </td>
                            <td>
                                @can('event_attendance_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.event-attendances.show', $eventAttendance->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('event_attendance_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.event-attendances.edit', $eventAttendance->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('event_attendance_delete')
                                    <form action="{{ route('admin.event-attendances.destroy', $eventAttendance->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('event_attendance_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.event-attendances.massDestroy') }}",
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
  let table = $('.datatable-memberEventAttendances:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection