@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.test.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.test.fields.id') }}
                        </th>
                        <td>
                            {{ $test->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.test.fields.course') }}
                        </th>
                        <td>
                            {{ $test->course->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.test.fields.lesson') }}
                        </th>
                        <td>
                            {{ $test->lesson->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.test.fields.title') }}
                        </th>
                        <td>
                            {{ $test->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.test.fields.description') }}
                        </th>
                        <td>
                            {!! $test->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.test.fields.is_published') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $test->is_published ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tests.index') }}">
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
            <a class="nav-link" href="#test_questions" role="tab" data-toggle="tab">
                {{ trans('cruds.question.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#test_test_results" role="tab" data-toggle="tab">
                {{ trans('cruds.testResult.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="test_questions">
            @includeIf('admin.tests.relationships.testQuestions', ['questions' => $test->testQuestions])
        </div>
        <div class="tab-pane" role="tabpanel" id="test_test_results">
            @includeIf('admin.tests.relationships.testTestResults', ['testResults' => $test->testTestResults])
        </div>
    </div>
</div>

@endsection