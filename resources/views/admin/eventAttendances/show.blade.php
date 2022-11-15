@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.eventAttendance.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.event-attendances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.eventAttendance.fields.id') }}
                        </th>
                        <td>
                            {{ $eventAttendance->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventAttendance.fields.event') }}
                        </th>
                        <td>
                            {{ $eventAttendance->event->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventAttendance.fields.member') }}
                        </th>
                        <td>
                            {{ $eventAttendance->member->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventAttendance.fields.dates') }}
                        </th>
                        <td>
                            {{ $eventAttendance->dates }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventAttendance.fields.receipt_no') }}
                        </th>
                        <td>
                            {{ $eventAttendance->receipt_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventAttendance.fields.notes') }}
                        </th>
                        <td>
                            {!! $eventAttendance->notes !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.event-attendances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection