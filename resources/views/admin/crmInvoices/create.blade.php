@extends('layouts.admin')
@section('content')


<div class="card"  id="invoice">
<form method="POST" action="{{ route("admin.crm-invoices.store") }}" enctype="multipart/form-data">
    @csrf
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                {{ trans('global.create') }} {{ trans('cruds.crmInvoice.title_singular') }}
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
                    <label class="required" for="invoice_no">{{ trans('cruds.crmInvoice.fields.invoice_no') }}</label>
                    <input readonly class="form-control {{ $errors->has('invoice_no') ? 'is-invalid' : '' }}" type="text" name="invoice_no" id="invoice_no" value="{{ old('invoice_no', $new_id_no) }}" required>
                    @if($errors->has('invoice_no'))
                        <div class="invalid-feedback">
                            {{ $errors->first('invoice_no') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.crmInvoice.fields.invoice_no_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="date">{{ trans('cruds.crmInvoice.fields.date') }}</label>
                    <input readonly class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date') }}" required>
                    @if($errors->has('date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('date') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.crmInvoice.fields.date_helper') }}</span>
                </div>

            
            
               
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label class="required" for="member_id">{{ trans('cruds.crmInvoice.fields.member') }}</label>
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
                <table class="table table-form">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Price</th>
                            <th class="d-none">Qty</th>
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
                            <td class="table-price" :class="{'table-error': errors['products.' + $index + '.price']}">
                                <input type="text"  class="form-control table-control price"  v-model="product.price">
                            </td>
                            <td class="d-none table-qty" :class="{'table-error': errors['products.' + $index + '.qty']}">
                                <input type="text" class="table-control" v-model="product.qty">
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
                            <td class="table-empty"></td>
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

            </div>
        </div>
        <div class="form-group d-none">
            <label for="product_id">{{ trans('cruds.crmInvoice.fields.product') }}</label>
            <select class="form-control select2 {{ $errors->has('product') ? 'is-invalid' : '' }}" name="product_id" id="product_id">
                @foreach($products as $id => $product)
                    <option value="{{ $id }}" {{ old('product_id') == $id ? 'selected' : '' }}>{{ $product }}</option>
                @endforeach
            </select>
            @if($errors->has('product'))
                <div class="invalid-feedback">
                    {{ $errors->first('product') }}
                </div>
            @endif
            <span class="help-block">{{ trans('cruds.crmInvoice.fields.product_helper') }}</span>
        </div>




        <div class="row">
            <div class="col-md-6">
                <div class="form-group d-none">
                    <label for="description">{{ trans('cruds.crmInvoice.fields.description') }}</label>
                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description') }}</textarea>
                    @if($errors->has('description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.crmInvoice.fields.description_helper') }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group d-none">
                    <label class="required" for="amount">{{ trans('cruds.crmInvoice.fields.amount') }}</label>
                    <input readonly class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="@{{grandTotal}}"  required>
                    @if($errors->has('amount'))
                        <div class="invalid-feedback">
                            {{ $errors->first('amount') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.crmInvoice.fields.amount_helper') }}</span>
                </div>
                <div class="form-group d-none">
                    <label class="required" for="paid">{{ trans('cruds.crmInvoice.fields.paid') }}</label>
                    <input readonly class="form-control {{ $errors->has('paid') ? 'is-invalid' : '' }}" type="number" name="paid" id="paid" value="{{ old('paid', '0') }}" step="0.01" required>
                    @if($errors->has('paid'))
                        <div class="invalid-feedback">
                            {{ $errors->first('paid') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.crmInvoice.fields.paid_helper') }}</span>
                </div>
            </div>
        </div>
        <div class="form-group d-none">
                <label class="required">{{ trans('cruds.crmInvoice.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\CrmInvoice::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', '1') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.crmInvoice.fields.status_helper') }}</span>
            </div>
            <div class="form-group d-none">
                <label for="items">{{ trans('cruds.crmInvoice.fields.items') }}</label>
                <input readonly class="form-control {{ $errors->has('items') ? 'is-invalid' : '' }}" type="text" name="items" id="items" value="{{ old('items', '') }}">
                @if($errors->has('items'))
                    <div class="invalid-feedback">
                        {{ $errors->first('items') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.crmInvoice.fields.items_helper') }}</span>
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
@endsection