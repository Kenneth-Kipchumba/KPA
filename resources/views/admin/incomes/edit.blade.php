@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.income.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.incomes.update", [$income->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="entry_date">{{ trans('cruds.income.fields.entry_date') }}</label>
                <input class="form-control date {{ $errors->has('entry_date') ? 'is-invalid' : '' }}" type="text" name="entry_date" id="entry_date" value="{{ old('entry_date', $income->entry_date) }}" required>
                @if($errors->has('entry_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('entry_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.income.fields.entry_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="receipt_no">{{ trans('cruds.income.fields.receipt_no') }}</label>
                <input class="form-control {{ $errors->has('receipt_no') ? 'is-invalid' : '' }}" type="text" name="receipt_no" id="receipt_no" value="{{ old('receipt_no', $income->receipt_no) }}">
                @if($errors->has('receipt_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('receipt_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.income.fields.receipt_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="member_id">{{ trans('cruds.income.fields.member') }}</label>
                <select class="form-control select2 {{ $errors->has('member') ? 'is-invalid' : '' }}" name="member_id" id="member_id">
                    @foreach($members as $id => $member)
                        <option value="{{ $id }}" {{ (old('member_id') ? old('member_id') : $income->member->id ?? '') == $id ? 'selected' : '' }}>{{ $member }}</option>
                    @endforeach
                </select>
                @if($errors->has('member'))
                    <div class="invalid-feedback">
                        {{ $errors->first('member') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.income.fields.member_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="invoice_id">{{ trans('cruds.income.fields.invoice') }}</label>
                <select class="form-control select2 {{ $errors->has('invoice') ? 'is-invalid' : '' }}" name="invoice_id" id="invoice_id">
                    @foreach($invoices as $id => $invoice)
                        <option value="{{ $id }}" {{ (old('invoice_id') ? old('invoice_id') : $income->invoice->id ?? '') == $id ? 'selected' : '' }}>{{ $invoice }}</option>
                    @endforeach
                </select>
                @if($errors->has('invoice'))
                    <div class="invalid-feedback">
                        {{ $errors->first('invoice') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.income.fields.invoice_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.income.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', $income->amount) }}" step="0.01" required>
                @if($errors->has('amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.income.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="income_category_id">{{ trans('cruds.income.fields.income_category') }}</label>
                <select class="form-control select2 {{ $errors->has('income_category') ? 'is-invalid' : '' }}" name="income_category_id" id="income_category_id">
                    @foreach($income_categories as $id => $income_category)
                        <option value="{{ $id }}" {{ (old('income_category_id') ? old('income_category_id') : $income->income_category->id ?? '') == $id ? 'selected' : '' }}>{{ $income_category }}</option>
                    @endforeach
                </select>
                @if($errors->has('income_category'))
                    <div class="invalid-feedback">
                        {{ $errors->first('income_category') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.income.fields.income_category_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.income.fields.mode') }}</label>
                <select class="form-control {{ $errors->has('mode') ? 'is-invalid' : '' }}" name="mode" id="mode">
                    <option value disabled {{ old('mode', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Income::MODE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('mode', $income->mode) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('mode'))
                    <div class="invalid-feedback">
                        {{ $errors->first('mode') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.income.fields.mode_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="transaction_no">{{ trans('cruds.income.fields.transaction_no') }}</label>
                <input class="form-control {{ $errors->has('transaction_no') ? 'is-invalid' : '' }}" type="text" name="transaction_no" id="transaction_no" value="{{ old('transaction_no', $income->transaction_no) }}">
                @if($errors->has('transaction_no'))
                    <div class="invalid-feedback">
                        {{ $errors->first('transaction_no') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.income.fields.transaction_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="notes">{{ trans('cruds.income.fields.notes') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" id="notes">{!! old('notes', $income->notes) !!}</textarea>
                @if($errors->has('notes'))
                    <div class="invalid-feedback">
                        {{ $errors->first('notes') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.income.fields.notes_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="items">{{ trans('cruds.income.fields.items') }}</label>
                <textarea class="form-control {{ $errors->has('items') ? 'is-invalid' : '' }}" name="items" id="items">{{ old('items', $income->items) }}</textarea>
                @if($errors->has('items'))
                    <div class="invalid-feedback">
                        {{ $errors->first('items') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.income.fields.items_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="file">{{ trans('cruds.income.fields.file') }}</label>
                <textarea class="form-control {{ $errors->has('file') ? 'is-invalid' : '' }}" name="file" id="file">{{ old('file', $income->file) }}</textarea>
                @if($errors->has('file'))
                    <div class="invalid-feedback">
                        {{ $errors->first('file') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.income.fields.file_helper') }}</span>
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
                xhr.open('POST', '{{ route('admin.incomes.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $income->id ?? 0 }}');
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