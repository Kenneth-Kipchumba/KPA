@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.email.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.emails.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.email.fields.id') }}
                        </th>
                        <td>
                            {{ $email->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.email.fields.list') }}
                        </th>
                        <td>
                            {{ App\Models\Email::LIST_SELECT[$email->list] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.email.fields.custom_list') }}
                        </th>
                        <td>
                            {{ $email->custom_list }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.email.fields.subject') }}
                        </th>
                        <td>
                            {{ $email->subject }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.email.fields.message') }}
                        </th>
                        <td>
                            {!! $email->message !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.email.fields.image') }}
                        </th>
                        <td>
                            @if($email->image)
                                <a href="{{ $email->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $email->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.email.fields.attachments') }}
                        </th>
                        <td>
                            @foreach($email->attachments as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.emails.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection