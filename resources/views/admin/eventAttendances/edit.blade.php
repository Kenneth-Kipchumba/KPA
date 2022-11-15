@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.eventAttendance.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.event-attendances.update", [$eventAttendance->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="event_id">{{ trans('cruds.eventAttendance.fields.event') }}</label>
                <select class="form-control select2 {{ $errors->has('event') ? 'is-invalid' : '' }}" name="event_id" id="event_id">
                    @foreach($events as $id => $event)
                        <option value="{{ $id }}" {{ (old('event_id') ? old('event_id') : $eventAttendance->event->id ?? '') == $id ? 'selected' : '' }}>{{ $event }}</option>
                    @endforeach
                </select>
                @if($errors->has('event'))
                    <div class="invalid-feedback">
                        {{ $errors->first('event') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eventAttendance.fields.event_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="member_id">{{ trans('cruds.eventAttendance.fields.member') }}</label>
                <select class="form-control select2 {{ $errors->has('member') ? 'is-invalid' : '' }}" name="member_id" id="member_id">
                    @foreach($members as $id => $member)
                        <option value="{{ $id }}" {{ (old('member_id') ? old('member_id') : $eventAttendance->member->id ?? '') == $id ? 'selected' : '' }}>{{ $member }}</option>
                    @endforeach
                </select>
                @if($errors->has('member'))
                    <div class="invalid-feedback">
                        {{ $errors->first('member') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eventAttendance.fields.member_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="dates">{{ trans('cruds.eventAttendance.fields.dates') }}</label>
                <input class="form-control {{ $errors->has('dates') ? 'is-invalid' : '' }}" type="text" name="dates" id="dates" value="{{ old('dates', $eventAttendance->dates) }}">
                @if($errors->has('dates'))
                    <div class="invalid-feedback">
                        {{ $errors->first('dates') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eventAttendance.fields.dates_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="receipt_no">{{ trans('cruds.eventAttendance.fields.receipt_no') }}</label>
                <input class="form-control {{ $errors->has('receipt_no') ? 'is-invalid' : '' }}" type="text" name="receipt_no" id="receipt_no" value="{{ old('receipt_no', $eventAttendance->receipt_no) }}">
                @if($errors->has('receipt_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('receipt_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eventAttendance.fields.receipt_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="notes">{{ trans('cruds.eventAttendance.fields.notes') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" id="notes">{!! old('notes', $eventAttendance->notes) !!}</textarea>
                @if($errors->has('notes'))
                    <div class="invalid-feedback">
                        {{ $errors->first('notes') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.eventAttendance.fields.notes_helper') }}</span>
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

@section('scripts')
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.event-attendances.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $eventAttendance->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

@endsection