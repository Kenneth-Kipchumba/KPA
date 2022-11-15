@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
            <div class="row">
                <div class="col-md-3"> {{ trans('cruds.crmInvoice.title_singular') }} {{ trans('global.list') }}</div>
                 
                <div class="col-md-9 text-right">
                    @can('crm_invoice_create')
                        <button class="generate btn btn-info" type="submit">
                            {{ trans('global.generate') }} {{ date('Y') }} {{ trans('cruds.crmInvoice.title') }}
                        </button>
                        <button class="email btn btn-dark" type="submit">
                            {{ trans('global.email') }} {{ date('Y') }} {{ trans('cruds.crmInvoice.title') }}
                        </button>
                    @endcan
                    @can('crm_invoice_create')
                        <a class="btn btn-success" href="{{ route('admin.crm-invoices.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.crmInvoice.title_singular') }}
                        </a>
                        <button class="btn btn-warning ml-2" data-toggle="modal" data-target="#csvImportModal">
                            {{ trans('global.app_csvImport') }}
                        </button>
                        @include('csvImport.modal', ['model' => 'CrmInvoice', 'route' => 'admin.crm-invoices.parseCsvImport'])
                    @endcan
                </div>
            </div>
    </div>

    
    <div class="card-body">

        <div class="progress_report mb-2" style="display:none;">
            <h3>Generating {{ date('Y') }} Invoices</h3>

            {{ $members }}
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 1%">0%</div>
            </div>
        </div>

        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-CrmInvoice">
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
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('crm_invoice_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.crm-invoices.massDestroy') }}",
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
    ajax: "{{ route('admin.crm-invoices.index') }}",
    columns: [
        { data: 'placeholder', name: 'placeholder' },
        { data: 'id', name: 'id', visible:false },
        { data: 'date', name: 'date' },
        { data: 'invoice_no', name: 'invoice_no' },
        { data: 'member_name', name: 'member.name' },
        { data: 'amount', name: 'amount' },
        { data: 'paid', name: 'paid' },
        { data: 'balance', name: 'balance' },
        { data: 'status', name: 'status' },
        { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  };

  let table = $('.datatable-CrmInvoice').DataTable(dtOverrideGlobals);

  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

  let members_email = {{ $members_email }};
  let members = {{ $members }};

  $('.generate').on('click', function(){
        //alert(members);
        $('.progress_report').show();
        invoice(1);

  });

  $('.email').on('click', function(){
        //alert(members);
        $('.progress_report').show();
        email(1);

  });

   async function invoice(id){    

        $.ajax({
            headers: {'x-csrf-token': _token},
            url: "{{ route('admin.crm-invoices.invoice') }}?id="+members[id],
            method: 'POST',
            success: function(data) {
                
                table.draw();
                
                if(id<members.length){
                    var progress = ((id/members.length)*100).toFixed(2);
                    $('.progress-bar').css('width', progress+'%');
                    $('.progress-bar').html(progress+'%');
                    invoice(id+1);
                }else{
                    $('.progress_report').hide();
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.progress_report').hide();
                alert(xhr.status+' '+thrownError+': '+xhr.responseText);
            }
        });
    }

    async function email(id){    

        $.ajax({
            headers: {'x-csrf-token': _token},
            url: "{{ route('admin.crm-invoices.email') }}?id="+members_email[id],
            method: 'POST',
            success: function(data) {
                
                table.draw();
                
                if(id<members_email.length){
                    var progress = ((id/members_email.length)*100).toFixed(2);
                    $('.progress-bar').css('width', progress+'%');
                    $('.progress-bar').html(progress+'%');
                    email(id+1);
                }else{
                    $('.progress_report').hide();
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('.progress_report').hide();
                alert(xhr.status+' '+thrownError+': '+xhr.responseText);
            }
        });

    }
    function animateValue(obj, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            obj.innerHTML = Math.floor(progress * (end - start) + start);
            if (progress < 1) {
            window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }



});

</script>
@endsection