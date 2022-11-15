<!DOCTYPE html>
<html>
<head>
        <title>{{ $title }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <link rel="stylesheet" href="{{ public_path('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
        <style type="text/css" media="screen">
            @page { size: A4 portrait;  }

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
            .mt-1{
                margin-top:8pt;
            }
            .mt-2{
                margin-top:24pt;
            }
            .text_caps{
                text-transform: uppercase;
            }
            body {
                font-size: 8pt;
                padding: 0pt;
                text-align:center; 
                background:#FFF;

            }
            section{
                padding: 24pt;
            }
            
            body, h1, h2, h3, h4, h5, h6, table, th, tr, td, p, div {
                line-height: 1.5;
            }
            .seller p, .buyer p{
                line-height: 0.8
            }

            .party-header {
                font-size: 1.0rem;
                line-height: 1.5;
                font-weight: 400;
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
                padding:3pt 3pt;
            }

            .card-body table td, .card-body table th {
                font-size:7pt;
            }

            .card-body table th{
                line-height:0.8;
            }
        </style>
    </head>

<body>
<section>


        <img src="{{ $logo }}" alt="logo" width="200">



        <div class="mt-1 text-center seller">
            @if($seller->name)
                <p class="seller-name" style="margin: 10px 0px 15px 0px;">
                    <strong>{{ $seller->name }}</strong>
                </p>
            @endif

            @if($seller->address)
                <p class="seller-address">
                    {{ __('invoices::invoice.address') }}: {{ $seller->address }}
                </p>
            @endif

            @if($seller->phone)
                <p class="seller-phone" style="margin-top:-5px;">
                     {{ $seller->phone }}
                </p>
            @endif

            
        </div>

        <div class="mt-2 border-0 pl-0 text-center party-header" width="48.5%">
            <strong  class="text_caps"> Financial Statement as of {{ $date }}</strong>
        </div>

        <div class="mt-2 text-center buyer">
            @if($buyer->name)
                <p class="buyer-name">
                    <strong>{{ $buyer->name }}</strong>
                </p>
            @endif

    
        </div>

        



            <div class="card-body row">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="50">
                                {{ trans('cruds.crmInvoice.fields.date') }}
                            </th>
                            <th width="50">
                                Ref No.
                            </th>
                           
                          
                           
                            <th width="180">
                                {{ trans('cruds.crmInvoice.fields.notes') }}
                            </th>
                           
                            <th width="50">
                                {{ trans('cruds.crmInvoice.fields.amount') }} Due
                            </th>
                            <th width="50">
                               Payment
                            
                            <th>
                                {{ trans('cruds.crmInvoice.fields.balance') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $key => $crmInvoice)
                            <tr data-entry-id="{{ $crmInvoice->id }}">
                                <td>
                                    {!! date('d-m-Y', strtotime($crmInvoice->date)) ?? '' !!}
                                </td>
								
								@if(isset($crmInvoice->receipt_no))
                                <td>
                                    {{ $crmInvoice->receipt_no ?? '' }}
                                </td>
                                @else
								<td>
                                    {{ $crmInvoice->invoice_no ?? '' }}
                                </td>
								@endif
                                
                                
								
								@if(isset($crmInvoice->receipt_no))
                                <td>
                                    {{  isset($crmInvoice->mode) ? App\Models\Income::MODE_SELECT[$crmInvoice->mode] : '' }} Payment 
                                    {{ $crmInvoice->transaction_no ?? '' }}
                                </td>
                                @else
								<td>
                                    {{ $crmInvoice->items ?? 'KPA Annual Membership 2022' }} 
                                </td>
								@endif
								
								@if(isset($crmInvoice->receipt_no))
                                <td>
                                    
                                </td>
                                <td class="text-right">
                                    {{ $crmInvoice->amount ?? '' }}
                                </td>
								 @else
								<td class="text-right">
                                    {{ $crmInvoice->amount ?? '' }}
                                </td>
								<td>
                                    
                                </td> 
								@endif
								
								
                                <td class="text-right">
                                    {{ $crmInvoice->account_balance ?? '' }}
                                </td>
                              
                                

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            </div>
</section>
</body>
</html>