@extends('layouts.admin')
@section('content')

<div class="card">
<form method="POST" action="{{ route("admin.users.update", [$user->id]) }}" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                    {{ trans('global.edit') }} {{ trans('cruds.user.title_singular') }}
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
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
            </div>
            <div class="form-group col-md-3">
                <label for="member_no">{{ trans('cruds.user.fields.member_no') }}</label>
                <input class="form-control {{ $errors->has('member_no') ? 'is-invalid' : '' }}" type="text" name="member_no" id="member_no" value="{{ old('member_no', $user->member_no) }}">
                @if($errors->has('member_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('member_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.member_no_helper') }}</span>
            </div>
            <div class="form-group col-md-3">
                <label for="date_registration">{{ trans('cruds.user.fields.date_registration') }}</label>
                <input readonly class="date form-control {{ $errors->has('date_registration') ? 'is-invalid' : '' }}" type="text" name="date_registration" id="date_registration" value="{{ old('date_registration', $user->date_registration) }}">
                @if($errors->has('date_registration'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_registration') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.date_registration_helper') }}</span>
            </div>
            
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
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
                            <option value="{{ $key }}" {{ old('designation', $user->designation) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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
                    <input class="form-control {{ $errors->has('designation_other') ? 'is-invalid' : '' }}" type="text" name="designation_other" id="designation_other" value="{{ old('designation_other', $user->designation_other) }}">
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
            <div class="form-group col-md-6"></div>

        
        </div>
        <div class="row">
            <div class="form-group col-md-3">
                <label class="required" for="phone">{{ trans('cruds.user.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" required>
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.phone_helper') }}</span>
            </div>
            <div class="form-group col-md-3">
                <label for="id_no">{{ trans('cruds.user.fields.id_no') }}</label>
                <input class="form-control {{ $errors->has('id_no') ? 'is-invalid' : '' }}" type="text" name="id_no" id="id_no" value="{{ old('id_no', $user->id_no) }}">
                @if($errors->has('id_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('id_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.id_no_helper') }}</span>
            </div>
            <div class="form-group col-md-3">
                <label for="board_reg_no">{{ trans('cruds.user.fields.board_reg_no') }}</label>
                <input class="form-control {{ $errors->has('board_reg_no') ? 'is-invalid' : '' }}" type="text" name="board_reg_no" id="board_reg_no" value="{{ old('board_reg_no', $user->board_reg_no) }}">
                @if($errors->has('board_reg_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('board_reg_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.board_reg_no_helper') }}</span>
            </div>
            
            <div class="form-group col-md-3">
                <label for="workstation">{{ trans('cruds.user.fields.workstation') }}</label>
                <input class="form-control {{ $errors->has('workstation') ? 'is-invalid' : '' }}" type="text" name="workstation" id="workstation" value="{{ old('workstation', $user->workstation) }}">
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
                <label for="postal_address">{{ trans('cruds.user.fields.postal_address') }}</label>
                <input class="form-control {{ $errors->has('postal_address') ? 'is-invalid' : '' }}" type="text" name="postal_address" id="postal_address" value="{{ old('postal_address', $user->postal_address) }}">
                @if($errors->has('postal_address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('postal_address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.postal_address_helper') }}</span>
            </div>
            <div class="form-group col-md-3">
                <label for="postal_code">{{ trans('cruds.user.fields.postal_code') }}</label>
                <input class="form-control {{ $errors->has('postal_code') ? 'is-invalid' : '' }}" type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
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
                        <option value="{{ $id }}" {{ (old('location_id') ? old('location_id') : $user->location->id ?? '') == $id ? 'selected' : '' }}>{{ $location }}</option>
                    @endforeach
                </select>
                @if($errors->has('location'))
                    <div class="invalid-feedback">
                        {{ $errors->first('location') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.location_helper') }}</span>
            </div>
            <div class="form-group col-md-3 mt-4">
                <div class="form-check {{ $errors->has('approved') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="approved" value="0">
                    <input class="form-check-input" type="checkbox" name="approved" id="approved" value="1" {{ $user->approved || old('approved', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="approved">{{ trans('cruds.user.fields.approved') }}</label>
                </div>
                @if($errors->has('approved'))
                    <div class="invalid-feedback">
                        {{ $errors->first('approved') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.approved_helper') }}</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-3">
                <label for="address">{{ trans('cruds.user.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', $user->address) }}">
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.address_helper') }}</span>
            </div>
            <div class="form-group col-md-3">
                <label for="alt_email">{{ trans('cruds.user.fields.alt_email') }}</label>
                <input class="form-control {{ $errors->has('alt_email') ? 'is-invalid' : '' }}" type="email" name="alt_email" id="alt_email" value="{{ old('alt_email', $user->alt_email) }}">
                @if($errors->has('alt_email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('alt_email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.alt_email_helper') }}</span>
            </div>
            <div class="form-group col-md-3">
                <label>{{ trans('cruds.user.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\User::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $user->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.status_helper') }}</span>
            </div>
           
           
        
        </div>
        <div class="row d-none ">
            <div class="form-group col-md-3">
                <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]" id="roles" multiple required>
                    @foreach($roles as $id => $roles)
                        <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || $user->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                    @endforeach
                </select>
                @if($errors->has('roles'))
                    <div class="invalid-feedback">
                        {{ $errors->first('roles') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
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
                <div class="form-group col-md-3">
                    <label for="latitude">{{ trans('cruds.user.fields.latitude') }}</label>
                    <input class="form-control {{ $errors->has('latitude') ? 'is-invalid' : '' }}" type="text" name="latitude" id="latitude" value="{{ old('latitude', $user->latitude) }}">
                    @if($errors->has('latitude'))
                        <div class="invalid-feedback">
                            {{ $errors->first('latitude') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.latitude_helper') }}</span>
                </div>
                <div class="form-group col-md-3">
                    <label for="longitude">{{ trans('cruds.user.fields.longitude') }}</label>
                    <input class="form-control {{ $errors->has('longitude') ? 'is-invalid' : '' }}" type="text" name="longitude" id="longitude" value="{{ old('longitude', $user->longitude) }}">
                    @if($errors->has('longitude'))
                        <div class="invalid-feedback">
                            {{ $errors->first('longitude') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.longitude_helper') }}</span>
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



@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#designation_specify').css('display','none');
        //$("select#roles").select2().select2('val', '2'); 
        $("select#roles").select2().select2('val', '2'); 

        $('select#designation').on('change',function(){
            if($(this).val()=='6'){ $('#designation_specify').css('display','block'); }
            else{ $('#designation_specify').css('display','none'); }});

        $('select#specialization_id').on('change',function(){
            if($(this).val()=='-1'){ $('#specialization_specify').css('display','block'); }
            else{ $('#specialization_specify').css('display','none'); }});


        document.getElementById("name").addEventListener("keypress", forceKeyPressUppercase, false);

    });
    Dropzone.options.photoDropzone = {
    url: '{{ route('admin.users.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="photo"]').remove()
      $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="photo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($user) && $user->photo)
      var file = {!! json_encode($user->photo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}
</script>
@endsection