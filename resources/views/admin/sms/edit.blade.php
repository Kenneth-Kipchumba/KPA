@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.sms.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sms.update", [$sms->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required">{{ trans('cruds.sms.fields.list') }}</label>
                <select class="form-control {{ $errors->has('list') ? 'is-invalid' : '' }}" name="list" id="list" required>
                    <option value disabled {{ old('list', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Sms::LIST_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('list', $sms->list) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('list'))
                    <div class="invalid-feedback">
                        {{ $errors->first('list') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sms.fields.list_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="custom_list">{{ trans('cruds.sms.fields.custom_list') }}</label>
                <textarea class="form-control {{ $errors->has('custom_list') ? 'is-invalid' : '' }}" name="custom_list" id="custom_list">{{ old('custom_list', $sms->custom_list) }}</textarea>
                @if($errors->has('custom_list'))
                    <div class="invalid-feedback">
                        {{ $errors->first('custom_list') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sms.fields.custom_list_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="message">{{ trans('cruds.sms.fields.message') }}</label>
                <textarea class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" name="message" id="message" required>{{ old('message', $sms->message) }}</textarea>
                @if($errors->has('message'))
                    <div class="invalid-feedback">
                        {{ $errors->first('message') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sms.fields.message_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection