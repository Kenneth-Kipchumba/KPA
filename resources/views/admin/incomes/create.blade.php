@extends('layouts.admin')
@section('content')

<div class="card" id="invoice">
<form method="POST" action="{{ route("admin.incomes.store") }}" enctype="multipart/form-data">
    @csrf
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                {{ trans('global.create') }} {{ trans('cruds.income.title_singular') }}
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
            <div class="col-md-3">
                <div class="form-group">

                    <label class="required" for="receipt_no">{{ trans('cruds.income.fields.receipt_no') }}</label>
                    <input readonly class="form-control {{ $errors->has('receipt_no') ? 'is-invalid' : '' }}" type="text" name="receipt_no" id="receipt_no" value="{{ old('receipt_no', $new_id_no) }}" required>
                    @if($errors->has('receipt_no'))
                        <div class="invalid-feedback">
                            {{ $errors->first('receipt_no') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.income.fields.receipt_no_helper') }}</span>
                </div>

               
            
                <div class="form-group">
                    <label class="required" for="entry_date">{{ trans('cruds.income.fields.entry_date') }}</label>
                    <input class="form-control date {{ $errors->has('entry_date') ? 'is-invalid' : '' }}" type="text" name="entry_date" id="entry_date" value="{{ old('entry_date') }}" required>
                    @if($errors->has('entry_date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('entry_date') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.income.fields.entry_date_helper') }}</span>
                </div>


                <div class="form-group">
                    <label class="required">{{ trans('cruds.income.fields.mode') }}</label>
                    <select class="form-control {{ $errors->has('mode') ? 'is-invalid' : '' }}" name="mode" id="mode" required>
                        <option value disabled {{ old('mode', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\Income::MODE_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('mode', '1') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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
                    <label class="required" for="amount">{{ trans('cruds.income.fields.amount') }}</label>
                    <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', '') }}" step="0.01" required>
                    @if($errors->has('amount'))
                        <div class="invalid-feedback">
                            {{ $errors->first('amount') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.income.fields.amount_helper') }}</span>
                </div>
                
                <div class="form-group">
                    <label class="required" for="transaction_no">{{ trans('cruds.income.fields.transaction_no') }}</label>
                    <input class="form-control {{ $errors->has('transaction_no') ? 'is-invalid' : '' }}" type="text" name="transaction_no" id="transaction_no" value="{{ old('transaction_no', '') }}" required>
                    @if($errors->has('transaction_no'))
                        <div class="invalid-feedback">
                            {{ $errors->first('transaction_no') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.income.fields.transaction_no_helper') }}</span>
                </div>

                
                <div class="form-group  d-none">
                    <label for="income_category_id">{{ trans('cruds.income.fields.income_category') }}</label>
                    <select class="form-control select2 {{ $errors->has('income_category') ? 'is-invalid' : '' }}" name="income_category_id" id="income_category_id">
                        @foreach($income_categories as $id => $income_category)
                            <option value="{{ $id }}" {{ old('income_category_id') == $id ? 'selected' : '' }}>{{ $income_category }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('income_category'))
                        <div class="invalid-feedback">
                            {{ $errors->first('income_category') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.income.fields.income_category_helper') }}</span>
                </div>
                <div  class="form-group d-none">
                    <label for="items">{{ trans('cruds.income.fields.items') }}</label>
                    <input readonly class="form-control {{ $errors->has('items') ? 'is-invalid' : '' }}" type="text" name="items" id="items" value="{{ old('items', '') }}">
                    @if($errors->has('items'))
                        <div class="invalid-feedback">
                            {{ $errors->first('items') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.income.fields.items_helper') }}</span>
                </div>


            
                <div class="form-group d-none">
                    <label for="file">{{ trans('cruds.income.fields.file') }}</label>
                    <textarea class="form-control {{ $errors->has('file') ? 'is-invalid' : '' }}" name="file" id="file">{{ old('file') }}</textarea>
                    @if($errors->has('file'))
                        <div class="invalid-feedback">
                            {{ $errors->first('file') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.income.fields.file_helper') }}</span>
                </div>


                
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="form-group col-md-6 ">
                        <label class="required" for="member">{{ trans('cruds.crmInvoice.fields.member') }}</label>
                        <select class="form-control select2 {{ $errors->has('member') ? 'is-invalid' : '' }}" name="member_id" id="member_id" required>
                            @foreach($members as $id => $member)
                                <option value="{{ $id }}" {{ old('member_id') == $id ? 'selected' : '' }}>{{ $member }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('member'))
                            <div class="invalid-feedback">
                                {{ $errors->first('member') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.crmInvoice.fields.member_helper') }}</span>
                    </div>


                    <div class="form-group col-md-6">
                        <label class="" for="invoice_id">{{ trans('cruds.crmInvoice.fields.member') }} / {{ trans('cruds.income.fields.invoice') }}</label>
                        <select class="form-control select2 {{ $errors->has('invoice') ? 'is-invalid' : '' }}" name="invoice_id" id="invoice_id" >
                        <option value="0" selected >Choose an Invoice</option>
                            @foreach($invoices as $id => $invoice)
                                <option value="{{ $invoice->id }}"  data-member="{{ $invoice->member_id }}" data-file="{{ $invoice->file }}" {{ old('invoice_id') == $id ? 'selected' : '' }}>{{ $invoice->member ? $invoice->member->member_no : '' }} - {{ $invoice->member ? $invoice->member->name : '' }} - {{ $invoice->invoice_no }} - {{ $invoice->date }} - {{ $invoice->amount }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('invoice'))
                            <div class="invalid-feedback">
                                {{ $errors->first('invoice') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.income.fields.invoice_helper') }}</span>
                    </div> 
                </div>



        <table class="table table-bordered table-form">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in form.products">
                    <td class="table-name" :class="{'table-error': errors['products.' + $index + '.name']}">

						<div class="form-group">
							<select v-model="product.product_id" @change="loadLine(this)"  class="product form-control {{ $errors->has('product') ? 'is-invalid' : '' }}" >
                                <option selected value="0"  data-price="0.00" >{{ trans('global.pleaseSelect') }}</option>
								
                                @foreach($products as $id => $product)
									<option value="{{ $id }}"  data-name="{{ $product->name }}" data-price="{{ $product->price }}" {{ old('product_id') == $id ? 'selected' : '' }}>{{ $product->name }} - {{ $product->price }}</option>
								@endforeach
                            </select>
                            <input type="text" class="product table-control d-none"  v-model="product.name" value="@{{product.name}}" required>
							@if($errors->has('product'))
								<div class="invalid-feedback">
									{{ $errors->first('product') }}
								</div>
							@endif
							</div>

                        

                    </td>
                    <td  class="table-price" :class="{'table-error': errors['products.' + $index + '.price']}">
                        <input readonly type="text "  class="form-control  price"  v-model="product.price">
                        <input type="hidden" class="table-control" v-model="product.qty">
                    </td>

                    <td class="table-total">
                        <span class="table-text">@{{product.qty * product.price}}</span>
                        <input type="hidden" class="table-control total"  v-model="product.total" value="@{{product.qty * product.price}}">
							
                    </td>
                    <td class="table-remove">
                        <span @click="remove(product)" class="table-remove-btn">&times;</span>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td class="table-empty" >
                        <a @click="addLine" class="btn btn-success">Add Line</a>
                    </td>
                    <td class="table-label">Sub Total</td>
                    <td class="table-amount">@{{subTotal}}</td>
                </tr>
                <tr>
                    <td class="table-empty" ></td>
                    <td class="table-label">{{ trans('cruds.crmInvoice.fields.discount') }}</td>
                    <td class="table-discount" :class="{'table-error': errors.discount}">
                        <div class="form-group">
                            <input v-model="form.discount" class="table-discount_input form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}"  name="discount" id="discount" value="{{ old('discount', '0') }}" >
                            @if($errors->has('discount'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('discount') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.crmInvoice.fields.discount_helper') }}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="table-empty" ></td>
                    <td class="table-label">Grand Total</td>
                    <td class="table-amount">@{{grandTotal}}</td>
                </tr>
            </tfoot>
        </table>



                <div id="pdf-viewer">
                  
                </div>


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
    $('select.product').on('change',function(){
        var name= $(this).find('option:selected').text();
        $(this).next('input').val(name).change();
    })
});
</script>
    <script src="{{ asset('js/vue.min.js') }}"></script>
    <script src="{{ asset('js/vue-resource.min.js') }}"></script>
    <script type="text/javascript">
        Vue.http.headers.common['X-CSRF-TOKEN'] = '{{csrf_token()}}';
        
        window._form = {
            invoice_no: '',
            client: '',
            client_address: '',
            title: '',
            invoice_date: '',
            due_date: '',
            discount: 0,
            products: [{
                product_id: 0,
                name: '',
                price: 0,
                qty: 1,
                total: 0
            }]
        };
    </script>
    <script src="{{ asset('js/invoice.js') }}"></script>

<script>
$(document).ready(function () {
    function forceKeyPressUppercase(e){
    var charInput = e.keyCode;
    if((charInput >= 97) && (charInput <= 122)) { // lowercase
      if(!e.ctrlKey && !e.metaKey && !e.altKey) { // no modifier key
        var newChar = charInput - 32;
        var start = e.target.selectionStart;
        var end = e.target.selectionEnd;
        e.target.value = e.target.value.substring(0, start) + String.fromCharCode(newChar) + e.target.value.substring(end);
        e.target.setSelectionRange(start+1, start+1);
        e.preventDefault();
      }
    }
  }

  document.getElementById("transaction_no").addEventListener("keypress", forceKeyPressUppercase, false);
  $("select#invoice_id").select2().select2('val', '0'); 
    $('#invoice_id').on('change',function(){
        PDFObject.embed("", "#pdf-viewer");
        var name= $(this).find('option:selected').text();
        var member = $(this).find('option:selected').data('member');
        //alert(member);
        $('#member_id').val(member).change();
        var file= $(this).find('option:selected').data('file');
        PDFObject.embed(file, "#pdf-viewer");
    })

});
</script>
@endsection