@extends('layouts.admin')
@section('content')

<div class="card" id="invoice">
<form method="POST" action="{{ route("admin.emails.store") }}" enctype="multipart/form-data">
    @csrf
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                {{ trans('global.create') }} {{ trans('cruds.email.title_singular') }}
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
            <div class="row">
              <div class="form-group col-md-3">
                  <label class="required">{{ trans('cruds.email.fields.list') }}</label>
                  <select class="form-control {{ $errors->has('list') ? 'is-invalid' : '' }}" name="list" id="list" required>
                      <option value disabled {{ old('list', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                      @foreach(App\Models\Email::LIST_SELECT as $key => $label)
                          <option value="{{ $key }}" {{ old('list', '1') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                      @endforeach
                  </select>
                  @if($errors->has('list'))
                      <div class="invalid-feedback">
                          {{ $errors->first('list') }}
                      </div>
                  @endif
                  <span class="help-block">{{ trans('cruds.email.fields.list_helper') }}</span>
              </div>
              <div class="form-group col-md-9">
                <label class="required" for="subject">{{ trans('cruds.email.fields.subject') }}</label>
                <input class="form-control {{ $errors->has('subject') ? 'is-invalid' : '' }}" type="text" name="subject" id="subject" value="{{ old('subject', '') }}" required>
                @if($errors->has('subject'))
                    <div class="invalid-feedback">
                        {{ $errors->first('subject') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.email.fields.subject_helper') }}</span>
            </div>

              <div class="form-group col-md-12 " id="custom_mail_list" style="display:none;">
                <label for="custom_list">{{ trans('cruds.email.fields.custom_list') }}</label>
                <textarea class="form-control {{ $errors->has('custom_list') ? 'is-invalid' : '' }}" name="custom_list" id="custom_list">{{ old('custom_list') }}</textarea>
                @if($errors->has('custom_list'))
                    <div class="invalid-feedback">
                        {{ $errors->first('custom_list') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.email.fields.custom_list_helper') }}</span>
            </div>
            </div>

            <div class="form-group">
                <label class="required" for="message">{{ trans('cruds.email.fields.message') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('message') ? 'is-invalid' : '' }}" name="message" id="message">{!! old('message') !!}</textarea>
                @if($errors->has('message'))
                    <div class="invalid-feedback">
                        {{ $errors->first('message') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.email.fields.message_helper') }}</span>
            </div>
            <div class="row">
              <div class="form-group col-md-6">
                  <label class="required" for="image">{{ trans('cruds.email.fields.image') }}</label>
                  <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                  </div>
                  @if($errors->has('image'))
                      <div class="invalid-feedback">
                          {{ $errors->first('image') }}
                      </div>
                  @endif
                  <span class="help-block">{{ trans('cruds.email.fields.image_helper') }}</span>
              </div>
              <div class="form-group col-md-6">
                  <label for="attachments">{{ trans('cruds.email.fields.attachments') }}</label>
                  <div class="needsclick dropzone {{ $errors->has('attachments') ? 'is-invalid' : '' }}" id="attachments-dropzone">
                  </div>
                  @if($errors->has('attachments'))
                      <div class="invalid-feedback">
                          {{ $errors->first('attachments') }}
                      </div>
                  @endif
                  <span class="help-block">{{ trans('cruds.email.fields.attachments_helper') }}</span>
              </div>
            </div>

            </div>
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

@section('scripts')



<script>
    $(document).ready(function () {

      $('#custom_mail_list').css('display','block');
        $("select#list").select2().select2('val', '1'); 

        $('select#list').on('change',function(){
            
            if($(this).val()=='1'){
               
                $('#custom_mail_list').css('display','block');
            }else{
                $('#custom_mail_list').css('display','none');
            }
           
            
        });


  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.emails.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $email->id ?? 0 }}');
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

<script>
    Dropzone.options.imageDropzone = {
    url: '{{ route('admin.emails.storeMedia') }}',
    maxFilesize: 5, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="image"]').remove()
      $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($email) && $email->image)
      var file = {!! json_encode($email->image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}
</script>
<script>
    var uploadedAttachmentsMap = {}
Dropzone.options.attachmentsDropzone = {
    url: '{{ route('admin.emails.storeMedia') }}',
    maxFilesize: 25, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 25
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="attachments[]" value="' + response.name + '">')
      uploadedAttachmentsMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedAttachmentsMap[file.name]
      }
      $('form').find('input[name="attachments[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($email) && $email->attachments)
          var files =
            {!! json_encode($email->attachments) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="attachments[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection