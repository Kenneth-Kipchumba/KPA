@extends('layouts.admin')
@section('content')

<div class="card" id="invoice">
<form method="POST" action="{{ route("admin.sms.store") }}" enctype="multipart/form-data">
    @csrf
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                {{ trans('global.create') }} {{ trans('cruds.sms.title_singular') }} :  <strong style="color: #0D86FF !important;"> {{ $balance }}</strong> <small> Current Balance </small>
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
            <div class="form-group col-md-3">
                <label class="required">{{ trans('cruds.sms.fields.list') }}</label>
                <select class="form-control {{ $errors->has('list') ? 'is-invalid' : '' }}" name="list" id="list" required>
                    <option value disabled {{ old('list', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Sms::LIST_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('list', '1') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('list'))
                    <div class="invalid-feedback">
                        {{ $errors->first('list') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sms.fields.list_helper') }}</span>
            </div>
            <div class="form-group col-md-9">
                <label for="custom_list">{{ trans('cruds.sms.fields.custom_list') }}</label>
                <input class="form-control {{ $errors->has('custom_list') ? 'is-invalid' : '' }}" type="text" name="custom_list" id="custom_list" value="{{ old('custom_list', '') }}">
                @if($errors->has('custom_list'))
                    <div class="invalid-feedback">
                        {{ $errors->first('custom_list') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sms.fields.custom_list_helper') }}</span>
            </div>
        </div>
            <div class="form-group">
                <label class="required" for="message">{{ trans('cruds.sms.fields.message') }}</label>
                <textarea class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" name="message" id="message" required>{{ old('message') }}</textarea>
                @if($errors->has('message'))
                    <div class="invalid-feedback">
                        {{ $errors->first('message') }}
                    </div>
                @endif
                <small id="sms_help" class="help-block">{{ trans('cruds.sms.fields.message_helper') }}</small>
            </div>
            </div>
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
$('#message').on('keyup', function(event) {
	   var len = $(this).val().length;
	   var total = 160;
	   var  remaining = total - len;
	   if (len > total) {
		  //$(this).val($(this).val().substring(0, len-1));
		  $('#sms_help').html("<font color='red'>You have exceeded the limit of 1 SMS. " + remaining + "</font>");
	   } else {
		   $('#sms_help').html("Remaining: " + remaining);
	   }
    });
});
</script>
@endsection