@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.testResult.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.test-results.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.testResult.fields.id') }}
                        </th>
                        <td>
                            {{ $testResult->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testResult.fields.test') }}
                        </th>
                        <td>
                            {{ $testResult->test->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testResult.fields.student') }}
                        </th>
                        <td>
                            {{ $testResult->student->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.testResult.fields.score') }}
                        </th>
                        <td>
                            {{ $testResult->score }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.test-results.index') }}">
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
            <a class="nav-link" href="#test_result_test_answers" role="tab" data-toggle="tab">
                {{ trans('cruds.testAnswer.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="test_result_test_answers">
            @includeIf('admin.testResults.relationships.testResultTestAnswers', ['testAnswers' => $testResult->testResultTestAnswers])
        </div>
    </div>
</div>

@endsection