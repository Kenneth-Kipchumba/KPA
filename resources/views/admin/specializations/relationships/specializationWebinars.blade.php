@can('webinar_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.webinars.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.webinar.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.webinar.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-specializationWebinars">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.webinar.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.webinar.fields.date_time') }}
                        </th>
                        <th>
                            {{ trans('cruds.webinar.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.webinar.fields.link') }}
                        </th>
                        <th>
                            {{ trans('cruds.webinar.fields.video') }}
                        </th>
                        <th>
                            {{ trans('cruds.webinar.fields.specialization') }}
                        </th>
                        <th>
                            {{ trans('cruds.webinar.fields.image') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($webinars as $key => $webinar)
                        <tr data-entry-id="{{ $webinar->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $webinar->id ?? '' }}
                            </td>
                            <td>
                                {{ $webinar->date_time ?? '' }}
                            </td>
                            <td>
                                {{ $webinar->title ?? '' }}
                            </td>
                            <td>
                                {{ $webinar->link ?? '' }}
                            </td>
                            <td>
                                {{ $webinar->video ?? '' }}
                            </td>
                            <td>
                                {{ $webinar->specialization->name ?? '' }}
                            </td>
                            <td>
                                @if($webinar->image)
                                    <a href="{{ $webinar->image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $webinar->image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @can('webinar_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.webinars.show', $webinar->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('webinar_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.webinars.edit', $webinar->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('webinar_delete')
                                    <form action="{{ route('admin.webinars.destroy', $webinar->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('webinar_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.webinars.massDestroy') }}",
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
  let table = $('.datatable-specializationWebinars:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection