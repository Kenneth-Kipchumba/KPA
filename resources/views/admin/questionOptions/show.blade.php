@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.questionOption.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.question-options.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.questionOption.fields.id') }}
                        </th>
                        <td>
                            {{ $questionOption->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionOption.fields.question') }}
                        </th>
                        <td>
                            {{ $questionOption->question->question_text ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionOption.fields.option_text') }}
                        </th>
                        <td>
                            {{ $questionOption->option_text }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.questionOption.fields.is_correct') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $questionOption->is_correct ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.question-options.index') }}">
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
            <a class="nav-link" href="#option_test_answers" role="tab" data-toggle="tab">
                {{ trans('cruds.testAnswer.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="option_test_answers">
            @includeIf('admin.questionOptions.relationships.optionTestAnswers', ['testAnswers' => $questionOption->optionTestAnswers])
        </div>
    </div>
</div>

@endsection