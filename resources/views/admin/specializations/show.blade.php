@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.specialization.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.specializations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.specialization.fields.id') }}
                        </th>
                        <td>
                            {{ $specialization->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.specialization.fields.name') }}
                        </th>
                        <td>
                            {{ $specialization->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.specialization.fields.description') }}
                        </th>
                        <td>
                            {!! $specialization->description !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.specializations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#specialization_users" role="tab" data-toggle="tab">
                {{ trans('cruds.user.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#specialization_events" role="tab" data-toggle="tab">
                {{ trans('cruds.event.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#specialization_courses" role="tab" data-toggle="tab">
                {{ trans('cruds.course.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#specialization_webinars" role="tab" data-toggle="tab">
                {{ trans('cruds.webinar.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="specialization_users">
            @includeIf('admin.specializations.relationships.specializationUsers', ['users' => $specialization->specializationUsers])
        </div>
        <div class="tab-pane" role="tabpanel" id="specialization_events">
            @includeIf('admin.specializations.relationships.specializationEvents', ['events' => $specialization->specializationEvents])
        </div>
        <div class="tab-pane" role="tabpanel" id="specialization_courses">
            @includeIf('admin.specializations.relationships.specializationCourses', ['courses' => $specialization->specializationCourses])
        </div>
        <div class="tab-pane" role="tabpanel" id="specialization_webinars">
            @includeIf('admin.specializations.relationships.specializationWebinars', ['webinars' => $specialization->specializationWebinars])
        </div>
    </div>
</div>

@endsection