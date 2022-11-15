@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.crmInvoice.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.crm-invoices.update", [$crmInvoice->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.crmInvoice.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $crmInvoice->date) }}" required>
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.crmInvoice.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="invoice_no">{{ trans('cruds.crmInvoice.fields.invoice_no') }}</label>
                <input class="form-control {{ $errors->has('invoice_no') ? 'is-invalid' : '' }}" type="text" name="invoice_no" id="invoice_no" value="{{ old('invoice_no', $crmInvoice->invoice_no) }}" required>
                @if($errors->has('invoice_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('invoice_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.crmInvoice.fields.invoice_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="member_id">{{ trans('cruds.crmInvoice.fields.member') }}</label>
                <select class="form-control select2 {{ $errors->has('member') ? 'is-invalid' : '' }}" name="member_id" id="member_id">
                    @foreach($members as $id => $member)
                        <option value="{{ $id }}" {{ (old('member_id') ? old('member_id') : $crmInvoice->member->id ?? '') == $id ? 'selected' : '' }}>{{ $member }}</option>
                    @endforeach
                </select>
                @if($errors->has('member'))
                    <div class="invalid-feedback">
                        {{ $errors->first('member') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.crmInvoice.fields.member_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="rate_id">{{ trans('cruds.crmInvoice.fields.rate') }}</label>
                <select class="form-control select2 {{ $errors->has('rate') ? 'is-invalid' : '' }}" name="rate_id" id="rate_id">
                    @foreach($rates as $id => $rate)
                        <option value="{{ $id }}" {{ (old('rate_id') ? old('rate_id') : $crmInvoice->rate->id ?? '') == $id ? 'selected' : '' }}>{{ $rate }}</option>
                    @endforeach
                </select>
                @if($errors->has('rate'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rate') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.crmInvoice.fields.rate_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.crmInvoice.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', $crmInvoice->amount) }}" step="0.01" required>
                @if($errors->has('amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.crmInvoice.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="paid">{{ trans('cruds.crmInvoice.fields.paid') }}</label>
                <input class="form-control {{ $errors->has('paid') ? 'is-invalid' : '' }}" type="number" name="paid" id="paid" value="{{ old('paid', $crmInvoice->paid) }}" step="0.01" required>
                @if($errors->has('paid'))
                    <div class="invalid-feedback">
                        {{ $errors->first('paid') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.crmInvoice.fields.paid_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="balance">{{ trans('cruds.crmInvoice.fields.balance') }}</label>
                <input class="form-control {{ $errors->has('balance') ? 'is-invalid' : '' }}" type="number" name="balance" id="balance" value="{{ old('balance', $crmInvoice->balance) }}" step="0.01">
                @if($errors->has('balance'))
                    <div class="invalid-feedback">
                        {{ $errors->first('balance') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.crmInvoice.fields.balance_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="discount">{{ trans('cruds.crmInvoice.fields.discount') }}</label>
                <input class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}" type="number" name="discount" id="discount" value="{{ old('discount', $crmInvoice->discount) }}" step="0.01">
                @if($errors->has('discount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('discount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.crmInvoice.fields.discount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="notes">{{ trans('cruds.crmInvoice.fields.notes') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" id="notes">{!! old('notes', $crmInvoice->notes) !!}</textarea>
                @if($errors->has('notes'))
                    <div class="invalid-feedback">
                        {{ $errors->first('notes') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.crmInvoice.fields.notes_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="items">{{ trans('cruds.crmInvoice.fields.items') }}</label>
                <textarea class="form-control {{ $errors->has('items') ? 'is-invalid' : '' }}" name="items" id="items">{{ old('items', $crmInvoice->items) }}</textarea>
                @if($errors->has('items'))
                    <div class="invalid-feedback">
                        {{ $errors->first('items') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.crmInvoice.fields.items_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="file">{{ trans('cruds.crmInvoice.fields.file') }}</label>
                <textarea class="form-control {{ $errors->has('file') ? 'is-invalid' : '' }}" name="file" id="file">{{ old('file', $crmInvoice->file) }}</textarea>
                @if($errors->has('file'))
                    <div class="invalid-feedback">
                        {{ $errors->first('file') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.crmInvoice.fields.file_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.crmInvoice.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\CrmInvoice::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $crmInvoice->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.crmInvoice.fields.status_helper') }}</span>
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
                xhr.open('POST', '{{ route('admin.crm-invoices.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $crmInvoice->id ?? 0 }}');
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