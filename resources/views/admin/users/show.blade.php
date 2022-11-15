

@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-header d-flex align-items-center">
        <h2><strong> {{ $user->member_no }} -  {{ $user->name }}</strong></h2>
    
        <a class="btn btn-default   mfs-auto mfe-1 d-print-none" href="{{ url()->previous() }}">
            {{ trans('global.back') }} 
        </a>
        <a class="btn btn-sm btn-info mfe-1 d-print-none" href="{{ route("admin.users.edit",$user->id) }}" >
            {{ trans('global.edit') }} {{ trans('cruds.user.title_singular') }}
        </a>
        @can('crm_customer_create')
            <a class="btn btn-success" href="{{ route('admin.crm-customers.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
            </a>
        @endcan
   </div>
    <div class="card-body mid">
      <div class="row mb-4">
         <div class="col-sm-4">

            <div><strong>{{ trans('cruds.user.fields.member_no') }}</strong> - {{ $user->member_no }}</div>
            <div><strong>  {{ trans('cruds.user.fields.name') }}</strong> -  {{ $user->name }}</div>
            <div><strong>  {{ trans('cruds.user.fields.email') }}</strong> -  {{ $user->email }}</div>
            <div><strong> {{ trans('cruds.user.fields.phone') }}</strong> -  {{ $user->phone }}</div>
            <div><strong>{{ trans('cruds.user.fields.id_no') }} </strong> - {{ $user->id_no }} </div>
            <div><strong>{{ trans('cruds.user.fields.board_reg_no') }} </strong> - {{ $user->board_reg_no }} </div>

        </div>
        <div class="col-sm-4">
            <div><strong>{{ trans('cruds.user.fields.designation') }} </strong> - {{ App\Models\User::DESIGNATION_SELECT[$user->designation] ?? '' }} </div>
            <div><strong>{{ trans('cruds.user.fields.specialization') }} </strong> - {{ $user->specialization ? $user->specialization->name : "" }} </div>
             
            <div><strong>{{ trans('cruds.user.fields.workstation') }} </strong> - {{ $user->workstation }} </div>

            <div><strong>{{ trans('cruds.user.fields.postal_address') }} </strong> -{{ $user->postal_address }} </div>
            <div><strong>{{ trans('cruds.user.fields.postal_code') }}  </strong> - {{ $user->postal_code }} </div>

            <div><strong>{{ trans('cruds.user.fields.location') }}  </strong> - {{  $user->location->name ?? ''  }} </div>

        </div>

        <div class="col-sm-4">

            <div><strong>  {{ trans('cruds.user.fields.date_registration') }} </strong> - {{ $user->date_registration != "1900-01-01" ? $user->date_registration : "" }} </div>

            <div><strong>         {{ trans('cruds.user.fields.alt_email') }} </strong> -  {{ $user->alt_email }} </div>
      
            <div><strong>{{ trans('cruds.user.fields.approved') }}</strong> - <input type="checkbox" disabled="disabled" {{ $user->approved ? 'checked' : '' }}> </div>

            <div><strong>{{ trans('cruds.user.fields.status') }}</strong> -{{ App\Models\User::STATUS_SELECT[$user->status] ?? '' }} </div>
        


            <div><strong> {{ trans('cruds.user.fields.roles') }} </strong> -
                             @foreach($user->roles as $key => $roles)
                                <span class="label label-info">{{ $roles->title }}</span>
                            @endforeach
                    </div>       
                             @if($user->photo)
                                <a href="{{ $user->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $user->photo->getUrl('thumb') }}">
                                </a>
                            @endif
        </div>
       
      </div>
   </div>

</div>
</div>



<div class="nav-tabs-boxed nav-tabs-boxed-left col-md-12">
    <ul class="nav nav-tabs col-md-2 p-0" role="tablist" id="relationship-tabs">
         <li class="nav-item">
            <a class="nav-link active" href="#member_incomes" role="tab" data-toggle="tab">
                {{ trans('cruds.income.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#member_crm_invoices" role="tab" data-toggle="tab">
                {{ trans('cruds.crmInvoice.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#member_event_attendances" role="tab" data-toggle="tab">
                {{ trans('cruds.eventAttendance.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#students_courses" role="tab" data-toggle="tab">
                {{ trans('cruds.course.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#statement" role="tab" data-toggle="tab">
                Statement
            </a>
        </li>
    </ul>
    <div class="tab-content col-md-10 p-0 b-none">
        <div class="tab-pane active" role="tabpanel" id="member_incomes">
        
            @includeIf('admin.users.relationships.memberIncomes', ['incomes' => $user->memberIncomes])
        </div>
        <div class="tab-pane" role="tabpanel" id="member_crm_invoices">
            @includeIf('admin.users.relationships.memberCrmInvoices', ['crmInvoices' => $user->memberCrmInvoices])
        </div>
        <div class="tab-pane" role="tabpanel" id="member_event_attendances">
            @includeIf('admin.users.relationships.memberEventAttendances', ['eventAttendances' => $user->memberEventAttendances])
        </div>
        <div class="tab-pane" role="tabpanel" id="students_courses">
            @includeIf('admin.users.relationships.studentsCourses', ['courses' => $user->studentsCourses])
        </div>
        <div class="tab-pane" role="tabpanel" id="statement">
            
        <div class="card">
            
        
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">Financal Statement</div>
                    <div class="col-md-6 text-right d-print-none">
                        @can('income_create')
                            <a class="btn btn-success"  href="{{ route('admin.users.send',$user->id) }}">
                               Email Statement 
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
            <div id="pdf-viewer"></div>

        </div>

        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $( document ).ready(function() {
        document.title = "KPA";
    });

    PDFObject.embed("{{ asset('storage/filename.pdf') ?? '' }}", "#pdf-viewer");

</script>
@endsection



