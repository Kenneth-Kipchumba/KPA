@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.question.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.questions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.question.fields.id') }}
                        </th>
                        <td>
                            {{ $question->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.question.fields.test') }}
                        </th>
                        <td>
                            {{ $question->test->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.question.fields.question_text') }}
                        </th>
                        <td>
                            {{ $question->question_text }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.question.fields.question_image') }}
                        </th>
                        <td>
                            @if($question->question_image)
                                <a href="{{ $question->question_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $question->question_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.question.fields.points') }}
                        </th>
                        <td>
                            {{ $question->points }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.questions.index') }}">
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
            <a class="nav-link" href="#question_question_options" role="tab" data-toggle="tab">
                {{ trans('cruds.questionOption.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#question_test_answers" role="tab" data-toggle="tab">
                {{ trans('cruds.testAnswer.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="question_question_options">
            @includeIf('admin.questions.relationships.questionQuestionOptions', ['questionOptions' => $question->questionQuestionOptions])
        </div>
        <div class="tab-pane" role="tabpanel" id="question_test_answers">
            @includeIf('admin.questions.relationships.questionTestAnswers', ['testAnswers' => $question->questionTestAnswers])
        </div>
    </div>
</div>

@endsection