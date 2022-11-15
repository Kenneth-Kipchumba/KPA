@extends('layouts.admin')
@section('content')
<div class="content">

@can('crm_invoice_access')
    <div class="row d-none">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="{{ $settings1['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings1['total_number']) }}</div>
                                    <div>{{ $settings1['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="{{ $settings2['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings2['total_number']) }}</div>
                                    <div>{{ $settings2['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="{{ $settings3['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings3['total_number']) }}</div>
                                    <div>{{ $settings3['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="{{ $settings4['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings4['total_number']) }}</div>
                                    <div>{{ $settings4['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        {{-- Widget - latest entries --}}
                        <div class="{{ $settings5['column_class'] }}" style="overflow-x: auto;">
                            <h3>{{ $settings5['chart_title'] }}</h3>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        @foreach($settings5['fields'] as $key => $value)
                                            <th>
                                                {{ trans(sprintf('cruds.%s.fields.%s', $settings5['translation_key'] ?? 'pleaseUpdateWidget', $key)) }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($settings5['data'] as $entry)
                                        <tr>
                                            @foreach($settings5['fields'] as $key => $value)
                                                <td>
                                                    @if($value === '')
                                                        {{ $entry->{$key} }}
                                                    @elseif(is_iterable($entry->{$key}))
                                                        @foreach($entry->{$key} as $subEentry)
                                                            <span class="label label-info">{{ $subEentry->{$value} }}</span>
                                                        @endforeach
                                                    @else
                                                        {{ data_get($entry, $key . '.' . $value) }}
                                                    @endif
                                                </td>
                                            @endforeach
                                            <td>   
                                          
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.incomes.show', $entry->id ) }}">
                                                    {{ trans('global.view') }} 
                                                </a>
                                      
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="{{ count($settings5['fields']) }}">{{ __('No entries found') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="{{ $chart6->options['column_class'] }}">
                            <h3>{!! $chart6->options['chart_title'] !!}</h3>
                            {!! $chart6->renderHtml() !!}
                        </div>
                        <div class="{{ $chart7->options['column_class'] }}">
                            <h3>{!! $chart7->options['chart_title'] !!}</h3>
                            {!! $chart7->renderHtml() !!}
                        </div>
                        

                    </div>
                </div>
            </div>
        </div>
    </div>
@endcan


<div class="card">
   <div class="card-header d-flex align-items-center">
        <h2><strong> {{ auth()->user()->member_no }} -  {{ auth()->user()->name }}</strong></h2>
    

        <a class="btn btn-sm btn-info  mfs-auto mfe-1 d-print-none"href="{{ route('profile.password.edit') }}" >
            {{ trans('global.my_profile') }}
        </a>
   </div>
    <div class="card-body mid">
      <div class="row mb-4">
         <div class="col-sm-4">

            <div><strong>{{ trans('cruds.user.fields.member_no') }}</strong> - {{ auth()->user()->member_no }}</div>
            <div><strong>{{ trans('cruds.user.fields.name') }}</strong> -  {{ auth()->user()->name }}</div>
            <div><strong>{{ trans('cruds.user.fields.email') }}</strong> -  {{ auth()->user()->email }}</div>
            <div><strong> {{ trans('cruds.user.fields.phone') }}</strong> -  {{ auth()->user()->phone }}</div>
            <div><strong>{{ trans('cruds.user.fields.id_no') }} </strong> - {{ auth()->user()->id_no }} </div>
            <div><strong>{{ trans('cruds.user.fields.board_reg_no') }} </strong> - {{ auth()->user()->board_reg_no }} </div>

        </div>
        <div class="col-sm-4">
            <div><strong>{{ trans('cruds.user.fields.designation') }} </strong> - {{ App\Models\User::DESIGNATION_SELECT[auth()->user()->designation] ?? '' }} </div>  
            <div><strong>{{ trans('cruds.user.fields.specialization') }} </strong> - {{ auth()->user()->specialization ? auth()->user()->specialization->name : "" }} </div>
            <div><strong>{{ trans('cruds.user.fields.workstation') }} </strong> - {{ auth()->user()->workstation }} </div>
            <div><strong>{{ trans('cruds.user.fields.custom_field_1') }} </strong> - {{ auth()->user()->custom_field_1 }} </div>
            <div><strong>{{ trans('cruds.user.fields.postal_address') }} </strong> -{{ auth()->user()->postal_address }} </div>
            <div><strong>{{ trans('cruds.user.fields.postal_code') }}  </strong> - {{ auth()->user()->postal_code }} </div>
            <div><strong>{{ trans('cruds.user.fields.location') }}  </strong> - {{  auth()->user()->location->name ?? ''  }} </div>

        </div>

        <div class="col-sm-4">

            <div><strong>  {{ trans('cruds.user.fields.date_registration') }} </strong> - {{ auth()->user()->date_registration != "1900-01-01" ? auth()->user()->date_registration : "" }} </div>

            <div><strong>         {{ trans('cruds.user.fields.alt_email') }} </strong> -  {{ auth()->user()->alt_email }} </div>
      
            <div><strong>{{ trans('cruds.user.fields.approved') }}</strong> - <input type="checkbox" disabled="disabled" {{ auth()->user()->approved ? 'checked' : '' }}> </div>

            <div><strong>{{ trans('cruds.user.fields.status') }}</strong> -{{ App\Models\User::STATUS_SELECT[auth()->user()->status] ?? '' }} </div>
        


            <div><strong> {{ trans('cruds.user.fields.roles') }} </strong> -
                             @foreach(auth()->user()->roles as $key => $roles)
                                <span class="label label-info">{{ $roles->title }}</span>
                            @endforeach
                    </div>       
                             @if(auth()->user()->photo)
                                <a href="{{ auth()->user()->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ auth()->user()->photo->getUrl('thumb') }}">
                                </a>
                            @endif
        </div>
       
      </div>
   </div>

</div>
</div>


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
                
            <a href="{{ route("admin.webinars.show",$webinar->id) }}">
                <img src="{{ $webinar->image->url }}" width="100%" alt="{!! $webinar->image->thumbnail !!}"/>
            </a>
            <hr>
            
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
@else
<div class="row">
    <div class="col-md-12 text-center">
        <br/><i class="fa-fw fas fa-users c-sidebar-nav-icon" style="font-size:172px; color:#ccc;"></i><br/><br/><br/>
        <h3>Please Renew your Annual Membership to Access <br/>Webinars and Course Materials.</h3><br/>
        
    </div>
    <div class="col-md-12 text-center">
    {!! $iframe !!}
    </div>
    <div class="col-md-6 text-left d-none">&nbsp;</div>
    <div class="col-md-6 text-left d-none" style="margin-left:-100px;">
        <h4> Pay Using MPESA </h4> 

        <h5> 1. Go to the M-Pesa Menu.<br/>
        2.  Select Pay Bill.<br/>
        3.  Enter Business No. <strong>891625</strong><br/>
        4.  Enter Account No. <strong>YOUR FULL NAMES</strong><br/>
        5.  Enter the Amount. <strong>3000.00</strong><br/>
        6.  Enter your M-Pesa PIN then send.<br/>
        </h5>
    </div>

@endif

</div>


@endsection
@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>{!! $chart6->renderJs() !!}{!! $chart7->renderJs() !!}
@endsection