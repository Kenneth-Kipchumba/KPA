@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.sms.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sms.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.sms.fields.id') }}
                        </th>
                        <td>
                            {{ $sms->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sms.fields.list') }}
                        </th>
                        <td>
                            {{ App\Models\Sms::LIST_SELECT[$sms->list] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sms.fields.custom_list') }}
                        </th>
                        <td>
                            {{ $sms->custom_list }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sms.fields.message') }}
                        </th>
                        <td>
                            {{ $sms->message }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sms.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection