<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ $invoice->name }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <link rel="stylesheet" href="{{ public_path('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
        <style type="text/css" media="screen">
            @page { size: A5 landscape;  }

            * {
                font-family: Arial, sans-serif;
            }
            html {
                margin: 0;
                padding:0;
            }
            th{
                text-align:center;
            }
            .text-center{
                text-align:center;
            }
            
            .text-left{
                text-align:left;
            }

            .text-right{
                text-align:right;
            }

            .seller-name{
                font-size:12pt;
            }
            .buyer-name{
                font-size:10pt;
            }

            tfoot.bt-1{
                border-top:1px solid #000;
                margin:8pt 0pt;
            }
            tfoot td{
                padding-left:20pt;
            }
            thead.bb-2 th{
                border-bottom:1px solid #000;
                margin:8pt 0pt;
            }
            .mt-5{
                margin-top:-9pt;
            }
            .text_caps{
                text-transform: uppercase;
            }
            body {
                font-size: 8pt;
                padding: 0pt;
                text-align:center; 
              

            }
            section{
                padding: 36pt;
            }
            body::after {
            content: "";
            background-image: url('{{ $invoice->getLogo() }}') !important;
            background-repeat: no-repeat;
            background-position: -21% 0;
            background-size: cover;
            opacity: 0.08;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            position: absolute;
            z-index: -1;   
            }
            body, h1, h2, h3, h4, h5, h6, table, th, tr, td, p, div {
                line-height: 1.5;
            }
            .seller p, .buyer p{
                line-height: 0.8
            }

            .party-header {
                font-size: 1.2rem;
                line-height: 1.5;
                font-weight: 400;
                margin-top:24pt;
            }
            .total-amount {
                font-size: 10pt;
                font-weight: 700;
            }
            table{
                width:100%;
                border-collapse: collapse; 
            }

            footer{
                position:absolute;
                bottom:0px;
                margin-top:-16pt;
            }

            .table tbody td{
                padding:3pt 0pt;
            }
        </style>
    </head>

    <body class="A5 landscape"  >
    <section class="sheet">
        {{-- Header --}}
        @if($invoice->logo)
            <img src="{{ $invoice->getLogo() }}" alt="logo" width="200">
        @endif
        {{-- Seller - Buyer --}}
        <table class="table mt-0 seller" cell-spacing>
            <tbody>
                <tr>
                    <td class="px-0 text-center seller">
                        @if($invoice->seller->name)
                            <p class="seller-name">
                                <strong>{{ $invoice->seller->name }}</strong>
                            </p>
                        @endif

                        @if($invoice->seller->address)
                            <p class="seller-address">
                                {{ __('invoices::invoice.address') }}: {{ $invoice->seller->address }}
                            </p>
                        @endif

                        @if($invoice->seller->code)
                            <p class="seller-code">
                                {{ __('invoices::invoice.code') }}: {{ $invoice->seller->code }}
                            </p>
                        @endif

                        @if($invoice->seller->vat)
                            <p class="seller-vat">
                                {{ __('invoices::invoice.vat') }}: {{ $invoice->seller->vat }}
                            </p>
                        @endif

                        @if($invoice->seller->phone)
                            <p class="seller-phone">
                                {{ __('invoices::invoice.phone') }}: {{ $invoice->seller->phone }}
                            </p>
                        @endif

                        @foreach($invoice->seller->custom_fields as $key => $value)
                            <p class="seller-custom-field">
                                {{ ucfirst($key) }}: {{ $value }}
                            </p>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
        {{-- Seller - Buyer --}}
        <table class="table buyer">
            <thead>
                <tr>
                    <th class="border-0 pl-0 party-header" width="48.5%">
                        <strong  class="text_caps">Receipt</strong>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-0 text-center buyer">
                        @if($invoice->buyer->name)
                            <p class="buyer-name">
                                <strong>{{ $invoice->buyer->name }}</strong>
                            </p>
                        @endif

                        @if($invoice->buyer->address)
                            <p class="buyer-address">
                                {{ __('invoices::invoice.address') }}: {{ $invoice->buyer->address }}
                            </p>
                        @endif

                        @if($invoice->buyer->vat)
                            <p class="buyer-vat">
                                {{ __('invoices::invoice.vat') }}: {{ $invoice->buyer->vat }}
                            </p>
                        @endif

                        @if($invoice->buyer->phone)
                            <p class="buyer-phone">
                                {{ __('invoices::invoice.phone') }}: {{ $invoice->buyer->phone }}
                            </p>
                        @endif
                      
                    </td>
                </tr>
            </tbody>
        </table>
        {{-- Table --}}
        <table class="table mt-5">
            <tbody>
                <tr>
                    <td class="border-0 pl-0" width="33%">
                        <p>Receipt No. <strong>{{ $invoice->buyer->custom_fields['receipt_no'] }}</strong></p>   
                    </td>

                    <td class="border-0 pl-0 text-right">
                         <p>Receipt Date: <strong>{{ $invoice->getDate() }}</strong></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table">
            <thead class="bb-2">
                <tr>
                    <th scope="col" width="30%" class="text-left">{{ __('invoices::invoice.description') }}</th>
                    @if($invoice->hasItemUnits)
                        <th scope="col" class="text-left">{{ __('invoices::invoice.units') }}</th>
                    @endif
                    <th scope="col" class="text-right">Category</th>
                    
                    
                    <th scope="col" class="text-right">{{ __('invoices::invoice.price') }}</th>
                    <th scope="col" class="text-center">{{ __('invoices::invoice.quantity') }}</th>
                    @if($invoice->hasItemDiscount)
                        <th scope="col" class="text-right">{{ __('invoices::invoice.discount') }}</th>
                    @endif
                    @if($invoice->hasItemTax)
                        <th scope="col" class="text-left">{{ __('invoices::invoice.tax') }}</th>
                    @endif
                    <th scope="col" width="10%" class="text-right pr-0">{{ __('invoices::invoice.sub_total') }}</th>
                </tr>
            </thead>
            <tbody>
                {{-- Items --}}
                @foreach($invoice->items as $item)
                <tr>
                    <td class="pl-0">{{ $item->title }}</td>
                    @if($invoice->hasItemUnits)
                        <td class="text-left">{{ $item->units }}</td>
                    @endif
                   
                    <td class="text-right"> </td>
                    
                    <td class="text-right">
                        {{ $invoice->formatCurrency($item->price_per_unit) }}
                    </td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    @if($invoice->hasItemDiscount)
                        <td class="text-right">
                            {{ $invoice->formatCurrency($item->discount) }}
                        </td>
                    @endif
                    @if($invoice->hasItemTax)
                        <td class="text-right">
                            {{ $invoice->formatCurrency($item->tax) }}
                        </td>
                    @endif

                    <td class="text-right pr-0">
                        {{ $invoice->formatCurrency($item->sub_total_price) }}
                    </td>
                </tr>
                @endforeach
              
            </tbody>
            <tfoot  class="mt-5 bt-1">
                {{-- Summary --}}
                @if($invoice->taxable_amount)
                    <tr>
                        <td colspan="{{ $invoice->table_columns - 3 }}" class="border-0"></td>
                        <td class="border-0"></td><td class="border-0"></td>
                        <td class="text-left pl-0"> {{ __('invoices::invoice.sub_total') }}</td>
                        <td class="text-right pr-0">
                            {{ $invoice->formatCurrency($invoice->taxable_amount) }}
                        </td>
                    </tr>
                @endif
                @if($invoice->hasItemOrInvoiceDiscount())
                    <tr>
                        <td colspan="{{ $invoice->table_columns - 3 }}" class="border-0"></td>
                        <td class="border-0"></td><td class="border-0"></td>
                        <td class="text-left pl-0">{{ __('invoices::invoice.total_discount') }}</td>
                        <td class="text-right pr-0">
                            {{ $invoice->formatCurrency($invoice->total_discount) }}
                        </td>
                    </tr>
                @endif
                    <tr>
                        <td colspan="{{ $invoice->table_columns - 3 }}" class="border-0"></td>
                        <td class="border-0"></td><td class="border-0"></td>
                        <td class="text-left pl-0">{{ __('invoices::invoice.total_amount') }}</td>
                        <td class="text-right pr-0 total-amount">
                            {{ $invoice->formatCurrency($invoice->total_amount) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="{{ $invoice->table_columns - 3 }}" class="border-0"></td>
                        <td class="border-0"></td><td class="border-0"></td>
                        <td class="text-left pl-0">Amount Paid</td>
                        <td class="text-right pr-0 total-amount">
                            {{ $invoice->formatCurrency($invoice->buyer->custom_fields['paid']) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="{{ $invoice->table_columns - 3 }}" class="border-0"></td>
                        <td class="border-0"></td><td class="border-0"></td>
                        <td class="text-left pl-0">Balance</td>
                        <td class="text-right pr-0 total-amount">
                            {{ $invoice->formatCurrency($invoice->buyer->custom_fields['balance']) }}
                        </td>
                    </tr>
            </tfoot>
        </table>

        @if($invoice->notes)
            <p>
                {{ trans('invoices::invoice.notes') }}: {!! $invoice->notes !!}
            </p>
        @endif
        <br/><br/>

        <footer class='text-left'>
           <small>Credit A/C <strong>{{ $invoice->buyer->name }}</strong> 
                Amount:{{ $invoice->total_amount }} 
                Paid: {{ $invoice->buyer->custom_fields['paid'] }} 
                Balance: 0.00 
                Mode:  {{ App\Models\Income::MODE_SELECT[$invoice->buyer->custom_fields['mode']] ?? '' }} 
                REF: {{ $invoice->buyer->custom_fields['transaction_no'] }} <br/>
                This is computer generated receipt no signature required.
            </small>
  
        </footer>

    </section>
        <script type="text/php">
            if (isset($pdf) && $PAGE_COUNT > 1) {
                $text = "Page {PAGE_NUM} / {PAGE_COUNT}";
                $size = 10;
                $font = $fontMetrics->getFont("Verdana");
                $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
                $x = ($pdf->get_width() - $width);
                $y = $pdf->get_height() - 35;
                $pdf->page_text($x, $y, $text, $font, $size);
            }
        </script>
    </body>
</html>
