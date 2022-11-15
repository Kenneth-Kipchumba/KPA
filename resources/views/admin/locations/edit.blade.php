@extends('layouts.admin')
@section('content')

<div class="card">
<form method="POST" action="{{ route("admin.locations.update", [$location->id]) }}" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                    {{ trans('global.edit') }} {{ trans('cruds.location.title_singular') }}
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

            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.location.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $location->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.location.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="latitude">{{ trans('cruds.location.fields.latitude') }}</label>
                <input class="form-control {{ $errors->has('latitude') ? 'is-invalid' : '' }}" type="text" name="latitude" id="latitude" value="{{ old('latitude', $location->latitude) }}">
                @if($errors->has('latitude'))
                    <div class="invalid-feedback">
                        {{ $errors->first('latitude') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.location.fields.latitude_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="longitude">{{ trans('cruds.location.fields.longitude') }}</label>
                <input class="form-control {{ $errors->has('longitude') ? 'is-invalid' : '' }}" type="text" name="longitude" id="longitude" value="{{ old('longitude', $location->longitude) }}">
                @if($errors->has('longitude'))
                    <div class="invalid-feedback">
                        {{ $errors->first('longitude') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.location.fields.longitude_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="location_type">{{ trans('cruds.location.fields.location_type') }}</label>
                <input class="form-control {{ $errors->has('location_type') ? 'is-invalid' : '' }}" type="text" name="location_type" id="location_type" value="{{ old('location_type', $location->location_type) }}">
                @if($errors->has('location_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('location_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.location.fields.location_type_helper') }}</span>
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