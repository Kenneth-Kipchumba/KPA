

@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-header d-flex align-items-center">
        <h2><strong> {{ auth()->user()->member_no }} -  {{ auth()->user()->name }}</strong></h2>
    
        <a class="btn btn-default   mfs-auto mfe-1 d-print-none" href="{{ url()->previous() }}">
            {{ trans('global.back') }} 
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



<div class="nav-tabs-boxed nav-tabs-boxed-left col-md-12">
    <ul class="nav nav-tabs col-md-2 p-0" role="tablist" id="relationship-tabs">
        <li class="nav-item ">
            <a class="nav-link active" href="#profile" role="tab" data-toggle="tab">
                Update Profile
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#password" role="tab" data-toggle="tab">
               Change Password
            </a>
        </li>
         <li class="nav-item">
            <a class="nav-link" href="#member_crm_invoices" role="tab" data-toggle="tab">
                {{ trans('cruds.crmInvoice.title') }}
            </a>
        </li>
         <li class="nav-item">
            <a class="nav-link " href="#member_incomes" role="tab" data-toggle="tab">
                {{ trans('cruds.income.title') }}
            </a>
        </li>
       
        <li class="nav-item d-none">
            <a class="nav-link" href="#member_event_attendances" role="tab" data-toggle="tab">
                {{ trans('cruds.eventAttendance.title') }}
            </a>
        </li>
        <li class="nav-item d-none">
            <a class="nav-link" href="#students_courses" role="tab" data-toggle="tab">
                {{ trans('cruds.course.title') }}
            </a>
        </li>
       
    </ul>
    <div class="tab-content col-md-10 p-0 b-none">
        <div class="tab-pane" role="tabpanel" id="member_crm_invoices">
            @includeIf('admin.users.relationships.memberCrmInvoices', ['crmInvoices' => auth()->user()->memberCrmInvoices])
        </div>
        <div class="tab-pane" role="tabpanel" id="member_incomes">
            @includeIf('admin.users.relationships.memberIncomes', ['incomes' => auth()->user()->memberIncomes])
        </div>
       
        <div class="tab-pane d-none" role="tabpanel" id="member_event_attendances">
            @includeIf('admin.users.relationships.memberEventAttendances', ['eventAttendances' => auth()->user()->memberEventAttendances])
        </div>
        <div class="tab-pane d-none" role="tabpanel" id="students_courses">
            @includeIf('admin.users.relationships.studentsCourses', ['courses' => auth()->user()->studentsCourses])
        </div>
        <div class="tab-pane active" role="tabpanel" id="profile">

                        <form method="POST" action="{{ route("profile.password.updateProfile") }}">
                            @csrf
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        {{ trans('global.my_profile') }}
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a class="btn btn-default" href="{{ url()->previous() }}">
                                            {{ trans('global.back') }} 
                                        </a>
                                        <button class="btn btn-success" type="submit">
                                            {{ trans('global.save') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required>
                                    @if($errors->has('name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="member_no">{{ trans('cruds.user.fields.member_no') }}</label>
                                    <input readonly class="form-control {{ $errors->has('member_no') ? 'is-invalid' : '' }}" type="text" name="member_no" id="member_no" value="{{ old('member_no', auth()->user()->member_no) }}">
                                    @if($errors->has('member_no'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('member_no') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.member_no_helper') }}</span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="date_registration">{{ trans('cruds.user.fields.date_registration') }}</label>
                                    <input readonly class="date form-control {{ $errors->has('date_registration') ? 'is-invalid' : '' }}" type="text" name="date_registration" id="date_registration" value="{{ old('date_registration', auth()->user()->date_registration) }}">
                                    @if($errors->has('date_registration'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('date_registration') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.date_registration_helper') }}</span>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required>
                                    @if($errors->has('email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ trans('cruds.user.fields.designation') }}</label>
                                        <select class="form-control select2 {{ $errors->has('designation') ? 'is-invalid' : '' }}" name="designation" id="designation">
                                            <option value disabled {{ old('designation', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Models\User::DESIGNATION_SELECT as $key => $label)
                                                <option value="{{ $key }}" {{ old('designation', auth()->user()->designation) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('designation'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('designation') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.user.fields.designation_helper') }}</span>
                                    </div>
                                    <div class="form-group" id="designation_specify" style="display:none;">
                                        <label for="designation_other">{{ trans('cruds.user.fields.designation_other') }}</label>
                                        <input class="form-control {{ $errors->has('designation_other') ? 'is-invalid' : '' }}" type="text" name="designation_other" id="designation_other" value="{{ old('designation_other', auth()->user()->designation_other) }}">
                                        @if($errors->has('designation_other'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('designation_other') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.user.fields.designation_other_helper') }}</span>
                                    </div>

                                </div>
                                <div class="form-group col-md-3">
                                    <div class="form-group">
                                        <label for="specialization_id">{{ trans('cruds.user.fields.specialization') }}</label>
                                        <select class="form-control select2 {{ $errors->has('specialization') ? 'is-invalid' : '' }}" name="specialization_id" id="specialization_id">
                                            @foreach($specializations as $id => $specialization)
                                                <option value="{{ $id }}" {{ (old('specialization_id') ? old('specialization_id') : auth()->user()->specialization->id ?? '') == $id ? 'selected' : '' }}>{{ $specialization }}</option>
                                            @endforeach
                                            <option value="-1"> Other (Specify)</option>
                                        </select>
                                        @if($errors->has('specialization'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('specialization') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.user.fields.specialization_helper') }}</span>
                                    </div>

                                    <div class="form-group" id="specialization_specify" style="display:none;">
                                        <label for="specialization_other">{{ trans('cruds.user.fields.specialization_other') }}</label>
                                        <input class="form-control {{ $errors->has('specialization_other') ? 'is-invalid' : '' }}" type="text" name="specialization_other" id="specialization_other" value="{{ old('specialization_other', auth()->user()->specialization_other) }}">
                                        @if($errors->has('specialization_other'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('specialization_other') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.user.fields.specialization_other_helper') }}</span>
                                    </div>
                                </div>
                               
                                <div class="form-group col-md-3">
                                    <label class="required" for="workstation">{{ trans('cruds.user.fields.workstation') }}</label>
                                    <input class="form-control {{ $errors->has('workstation') ? 'is-invalid' : '' }}" type="text" name="workstation" id="workstation" value="{{ old('workstation', auth()->user()->workstation) }}" required>
                                    @if($errors->has('workstation'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('workstation') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.workstation_helper') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class="required" for="phone">{{ trans('cruds.user.fields.phone') }}</label>
                                    <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone) }}" required>
                                    @if($errors->has('phone'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('phone') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.phone_helper') }}</span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="id_no">{{ trans('cruds.user.fields.id_no') }}</label>
                                    <input class="form-control {{ $errors->has('id_no') ? 'is-invalid' : '' }}" type="text" name="id_no" id="id_no" value="{{ old('id_no', auth()->user()->id_no) }}">
                                    @if($errors->has('id_no'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('id_no') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.id_no_helper') }}</span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="board_reg_no">{{ trans('cruds.user.fields.board_reg_no') }}</label>
                                    <input class="form-control {{ $errors->has('board_reg_no') ? 'is-invalid' : '' }}" type="text" name="board_reg_no" id="board_reg_no" value="{{ old('board_reg_no', auth()->user()->board_reg_no) }}">
                                    @if($errors->has('board_reg_no'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('board_reg_no') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.board_reg_no_helper') }}</span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="custom_field_1">{{ trans('cruds.user.fields.custom_field_1') }}</label>
                                    <input class="form-control {{ $errors->has('custom_field_1') ? 'is-invalid' : '' }}" type="text" name="custom_field_1" id="custom_field_1" value="{{ old('custom_field_1', auth()->user()->custom_field_1) }}">
                                    @if($errors->has('custom_field_1'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('custom_field_1') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.custom_field_1_helper') }}</span>
                                </div>
                                
                            </div>
                            <div class="row">
                            
                                <div class="form-group col-md-3">
                                    <label for="postal_address">{{ trans('cruds.user.fields.postal_address') }}</label>
                                    <input class="form-control {{ $errors->has('postal_address') ? 'is-invalid' : '' }}" type="text" name="postal_address" id="postal_address" value="{{ old('postal_address', auth()->user()->postal_address) }}">
                                    @if($errors->has('postal_address'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('postal_address') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.postal_address_helper') }}</span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="postal_code">{{ trans('cruds.user.fields.postal_code') }}</label>
                                    <input class="form-control {{ $errors->has('postal_code') ? 'is-invalid' : '' }}" type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', auth()->user()->postal_code) }}">
                                    @if($errors->has('postal_code'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('postal_code') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.postal_code_helper') }}</span>
                                </div>

                            
                                <div class="form-group col-md-3">
                                    <label for="location_id">{{ trans('cruds.user.fields.location') }}</label>
                                    <select class="form-control select2 {{ $errors->has('location') ? 'is-invalid' : '' }}" name="location_id" id="location_id">
                                        @foreach($locations as $id => $location)
                                            <option value="{{ $id }}" {{ (old('location_id') ? old('location_id') : auth()->user()->location->id ?? '') == $id ? 'selected' : '' }}>{{ $location }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('location'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('location') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.location_helper') }}</span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="alt_email">{{ trans('cruds.user.fields.alt_email') }}</label>
                                    <input class="form-control {{ $errors->has('alt_email') ? 'is-invalid' : '' }}" type="email" name="alt_email" id="alt_email" value="{{ old('alt_email', auth()->user()->alt_email) }}">
                                    @if($errors->has('alt_email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('alt_email') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.alt_email_helper') }}</span>
                                </div>
                               
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="bio">{{ trans('cruds.user.fields.bio') }}</label>
                                    <textarea class="form-control ckeditor {{ $errors->has('bio') ? 'is-invalid' : '' }}" name="bio" id="bio">{!! old('bio', auth()->user()->bio) !!}</textarea>
                                    @if($errors->has('bio'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('bio') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.bio_helper') }}</span>
                                </div>
                            </div>
                            <div class="row d-none">
                                <div class="form-group col-md-3">
                                    <label for="address">{{ trans('cruds.user.fields.address') }}</label>
                                    <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', auth()->user()->address) }}">
                                    @if($errors->has('address'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('address') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.address_helper') }}</span>
                                </div>

                               
                                <div class="form-group col-md-3">
                                        <label for="photo">{{ trans('cruds.user.fields.photo') }}</label>
                                        <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                                        </div>
                                        @if($errors->has('photo'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('photo') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.user.fields.photo_helper') }}</span>
                                    </div>
                            
                            
                            </div>
          
                                
                            
                            </div>
                            <div class="row"></div>
                            <div class="row"></div>

                                <div class="card-footer form-group text-right">
                                    <a class="btn btn-default" href="{{ url()->previous() }}">
                                        {{ trans('global.back') }} 
                                    </a>
                                    <button class="btn btn-success" type="submit">
                                        {{ trans('global.save') }}
                                    </button>
                            </div>
                        </form>
               

        </div>
        <div class="tab-pane" role="tabpanel" id="password">

            <div class="row">
                <div class="col-md-12">
                    <div class="card b-none">
                        <div class="card-header">
                            {{ trans('global.change_password') }}
                        </div>
                        <div class="card-body row">
                            <div class="col-md-6">
                                <form method="POST" action="{{ route("profile.password.update") }}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="required" for="title">New {{ trans('cruds.user.fields.password') }}</label>
                                        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" required>
                                        @if($errors->has('password'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('password') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="required" for="title">Repeat New {{ trans('cruds.user.fields.password') }}</label>
                                        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" required>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-danger" type="submit">
                                            {{ trans('global.save') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                   
                </div>
                <div class="col-md-6 d-none">
                    <div class="card">
                        <div class="card-header">
                            {{ trans('global.delete_account') }}
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route("profile.password.destroyProfile") }}" onsubmit="return prompt('{{ __('global.delete_account_warning') }}') == '{{ auth()->user()->email }}'">
                                @csrf
                                <div class="form-group">
                                    <button class="btn btn-danger" type="submit">
                                        {{ trans('global.delete') }}
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#designation_specify').css('display','none');
        $("select#roles").select2().select2('val', '2'); 

        $('select#designation').on('change',function(){
            if($(this).val()=='6'){ $('#designation_specify').css('display','block'); }
            else{ $('#designation_specify').css('display','none'); }});

        $('select#specialization_id').on('change',function(){
            if($(this).val()=='-1'){ $('#specialization_specify').css('display','block'); }
            else{ $('#specialization_specify').css('display','none'); }});

        var allEditors = document.querySelectorAll('.ckeditor');
        for (var i = 0; i < allEditors.length; ++i) {
            ClassicEditor.create(
            allEditors[i]
            );
        }
    });
</script>



@endsection


