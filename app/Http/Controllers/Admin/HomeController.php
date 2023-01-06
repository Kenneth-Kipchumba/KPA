<?php

namespace App\Http\Controllers\Admin;


use App\Models\Income;
use App\Models\IncomeCategory;
use App\Models\User;
use App\Models\Webinar;
use App\Models\Rate;

use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;


use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Pesapal;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class HomeController
{
    public function index()
    {
        $settings1 = [
            'chart_title'           => 'Members',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\User',
            'group_by_field'        => 'email_verified_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'd-m-Y H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'user',
        ];

        $settings1['total_number'] = 0;
        if (class_exists($settings1['model'])) {
            $settings1['total_number'] = $settings1['model']::when(isset($settings1['filter_field']), function ($query) use ($settings1) {
                if (isset($settings1['filter_days'])) {
                    return $query->where($settings1['filter_field'], '>=',
                now()->subDays($settings1['filter_days'])->format('d-m-Y'));
                }
                if (isset($settings1['filter_period'])) {
                    switch ($settings1['filter_period']) {
                case 'week': $start = date('d-m-Y', strtotime('last Monday')); break;
                case 'month': $start = date('Y-m') . '-01'; break;
                case 'year': $start = date('Y') . '-01-01'; break;
            }
                    if (isset($start)) {
                        return $query->where($settings1['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings1['aggregate_function'] ?? 'count'}($settings1['aggregate_field'] ?? '*');
        }

        $settings2 = [
            'chart_title'           => 'Mail Outbox',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Email',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'd-m-Y H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'email',
        ];

        $settings2['total_number'] = 0;
        if (class_exists($settings2['model'])) {
            $settings2['total_number'] = $settings2['model']::when(isset($settings2['filter_field']), function ($query) use ($settings2) {
                if (isset($settings2['filter_days'])) {
                    return $query->where($settings2['filter_field'], '>=',
                now()->subDays($settings2['filter_days'])->format('d-m-Y'));
                }
                if (isset($settings2['filter_period'])) {
                    switch ($settings2['filter_period']) {
                case 'week': $start = date('d-m-Y', strtotime('last Monday')); break;
                case 'month': $start = date('Y-m') . '-01'; break;
                case 'year': $start = date('Y') . '-01-01'; break;
            }
                    if (isset($start)) {
                        return $query->where($settings2['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings2['aggregate_function'] ?? 'count'}($settings2['aggregate_field'] ?? '*');
        }

        $settings3 = [
            'chart_title'           => 'Invoices',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\CrmInvoice',
            'group_by_field'        => 'date',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'sum',
            'aggregate_field'       => 'amount',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'd-m-Y H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'crmInvoice',
        ];

        $settings3['total_number'] = 0;
        if (class_exists($settings3['model'])) {
            $settings3['total_number'] = $settings3['model']::when(isset($settings3['filter_field']), function ($query) use ($settings3) {
                if (isset($settings3['filter_days'])) {
                    return $query->where($settings3['filter_field'], '>=',
                now()->subDays($settings3['filter_days'])->format('d-m-Y'));
                }
                if (isset($settings3['filter_period'])) {
                    switch ($settings3['filter_period']) {
                case 'week': $start = date('d-m-Y', strtotime('last Monday')); break;
                case 'month': $start = date('Y-m') . '-01'; break;
                case 'year': $start = date('Y') . '-01-01'; break;
            }
                    if (isset($start)) {
                        return $query->where($settings3['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings3['aggregate_function'] ?? 'count'}($settings3['aggregate_field'] ?? '*');
        }

        $settings4 = [
            'chart_title'           => 'Receipts',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Income',
            'group_by_field'        => 'entry_date',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'sum',
            'aggregate_field'       => 'amount',
            'filter_field'          => 'created_at',
            'filter_period'         => 'year',
            'group_by_field_format' => 'd-m-Y',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'income',
        ];

        $settings4['total_number'] = 0;
        if (class_exists($settings4['model'])) {
            $settings4['total_number'] = $settings4['model']::when(isset($settings4['filter_field']), function ($query) use ($settings4) {
                if (isset($settings4['filter_days'])) {
                    return $query->where($settings4['filter_field'], '>=',
                now()->subDays($settings4['filter_days'])->format('d-m-Y'));
                }
                if (isset($settings4['filter_period'])) {
                    switch ($settings4['filter_period']) {
                case 'week': $start = date('d-m-Y', strtotime('last Monday')); break;
                case 'month': $start = date('Y-m') . '-01'; break;
                case 'year': $start = date('Y') . '-01-01'; break;
            }
                    if (isset($start)) {
                        return $query->where($settings4['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings4['aggregate_function'] ?? 'count'}($settings4['aggregate_field'] ?? '*');
        }

        $settings5 = [
            'chart_title'           => 'New Receipts',
            'chart_type'            => 'latest_entries',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Income',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'd-m-Y H:i:s',
            'column_class'          => 'col-md-12',
            'entries_number'        => '20',
            'fields'                => [
                'entry_date' => '',
                'receipt_no' => '',
                'member'     => 'fulldetails',
                'amount'     => '',
                'transaction_no'  => '',
               
            ],
            'translation_key' => 'income',
        ];

        $settings5['data'] = [];
        if (class_exists($settings5['model'])) {
            $settings5['data'] = $settings5['model']::with('member')
                ->take($settings5['entries_number'])
                ->orderBy('id','DESC')
                ->get();
        }

        if (!array_key_exists('fields', $settings5)) {
            $settings5['fields'] = [];
        }

        $settings6 = [
            'chart_title'           => 'Monthly Invoices',
            'chart_type'            => 'line',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\CrmInvoice',
            'group_by_field'        => 'date',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'sum',
            'aggregate_field'       => 'amount',
            'filter_field'          => 'created_at',
            'filter_period'         => 'month',
            'group_by_field_format' => 'd-m-Y',
            'column_class'          => 'col-md-6',
            'entries_number'        => '5',
            'translation_key'       => 'crmInvoice',
        ];

        $chart6 = new LaravelChart($settings6);

        $settings7 = [
            'chart_title'           => 'Monthly Receipts',
            'chart_type'            => 'line',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Income',
            'group_by_field'        => 'entry_date',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'sum',
            'aggregate_field'       => 'amount',
            'filter_field'          => 'created_at',
            'filter_period'         => 'month',
            'group_by_field_format' => 'd-m-Y',
            'column_class'          => 'col-md-6',
            'entries_number'        => '5',
            'translation_key'       => 'income',
        ];

        $chart7 = new LaravelChart($settings7);

        $settings8 = [
            'chart_title'           => 'Catch Up Masomo',
            'chart_type'            => 'latest_entries',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Webinar',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'd-m-Y H:i:s',
            'column_class'          => 'col-md-12',
            'entries_number'        => '10',
            'fields'                => [
                'title'     => '',
                'video'     => '',
                'date_time' => '',
            ],
            'translation_key' => 'webinar',
        ];

        $settings8['data'] = [];
        if (class_exists($settings8['model'])) {
            $settings8['data'] = $settings8['model']::latest()
                ->take($settings8['entries_number'])
                ->get();
        }

        if (!array_key_exists('fields', $settings8)) {
            $settings8['fields'] = [];
        }

        $webinars = Webinar::orderBy('date_time', 'DESC')->get();





        $string = auth()->user()->name;
        $words = explode(' ', $string);
        $lname = array_pop($words);
        $fname = implode(' ', $words);

        //$term = 'Membership '.date("Y");
        $term = 'Membership 2021';
        //dd($term);
        $rate = Rate::where('name','LIKE','%'.$term.'%')->first();

        $details = array(
            'amount' => $rate->price,
            'description' => $rate->name,
            'type' => 'MERCHANT',
            'first_name' => $fname,
            'last_name' => $lname,
            'email' => auth()->user()->email,
            'phonenumber' => auth()->user()->phone,
            'height'=>'600px',
            //'currency' => 'USD'
        );
        $iframe=Pesapal::makePayment($details);


        return view('home', compact('settings1', 'settings2', 'settings3', 'settings4', 'settings5', 'chart6', 'chart7', 'settings8', 'webinars','iframe'));
    }

    /*public function payment(){//initiates payment
        $payments = new Payment;
        $payments -> businessid = Auth::guard('business')->id(); //Business ID
        $payments -> transactionid = Pesapal::random_reference();
        $payments -> status = 'NEW'; //if user gets to iframe then exits, i prefer to have that as a new/lost transaction, not pending
        $payments -> amount = 10;
        $payments -> save();

        $details = array(
            'amount' => $payments -> amount,
            'description' => 'Test Transaction',
            'type' => 'MERCHANT',
            'first_name' => 'Fname',
            'last_name' => 'Lname',
            'email' => 'test@test.com',
            'phonenumber' => '254-723232323',
            'reference' => $payments -> transactionid,
            'height'=>'400px',
            //'currency' => 'USD'
        );
        $iframe=Pesapal::makePayment($details);

        return view('payments.business.pesapal', compact('iframe'));
    }*/

    
    public function paymentsuccess(Request $request)//just tells u payment has gone thru..but not confirmed
    {
        $trackingid = $request->input('tracking_id');
        $ref = $request->input('merchant_reference');

        $member = User::all()->find(auth()->user()->id);
        $member->status = 2;
        $member->save();

        $term = 'Membership '.date("Y");
        $rate = Rate::where('name','LIKE','%'.$term.'%')->first();

        $new_id=str_pad(Income::max('id')+1, 5, '0', STR_PAD_LEFT);
        $receipt_no = 'RE-'.date("Y")."-".$new_id;

        $customer = new Party([
            'name'          => $member->member_no." - ".$member->name,
            'code'          => $receipt_no,
            'custom_fields' => [
                //'invoice_no' => $invoice->invoice_no,
                'receipt_no' => $receipt_no,
                'paid' => $rate->price,
                'balance' => 0,
                'mode' => 'PESAPAL',
                'transaction_no' => $ref
            ],
        ]);

        $seller = new Party([
            'name'          => 'Kenya Paediatric Association',
            'address'       => 'KMA Center 3rd Floor, Office suite 301, Upper Hill, Mara Road, Nairobi P.O.Box 45820 00100 GPO Nairobi, Kenya',
            'phone'         => 'Email: membership@kenyapaediatric.org  Tel: +254 020 2725309 / 2726298 Cell: +254 726 161590'
        ]);


        $invoice_items = [];
        $invoice_total = 0;
        $line =  (new InvoiceItem())->title($rate->name)->pricePerUnit($rate->price)->quantity(1);
        $invoice_total += $rate->price;
        array_push($invoice_items, $line);


        $receipt = Invoice::make()
        ->buyer($customer)
        ->seller($seller)
        ->addItems($invoice_items)
        //->totalDiscount($invoice->discount) 
        ->totalAmount($rate->price)
        ->filename('RECEIPT-'.$receipt_no)
        ->logo(asset('img/logo_kpa_full.png'))
        ->template('default_receipt')
        ->save('public');

        $receipt_url = $receipt->url();

        $data = []; 
        $data['entry_date'] = date("d-m-Y");
        $data['notes'] = $trackingid;
        $data['transaction_no'] = $ref;
        $data['amount'] = $rate->price;
        $data['balance'] = 0;
        $data['mode'] = 6;
        $data['member_id'] = auth()->user()->id;
        $data['receipt_no'] = $receipt_no;
        $data['status'] = 2;
        $data['file'] =  $receipt_url;
        
        $income = Income::create($data);

        return redirect()->route('admin.home')->with(['message' => 'Payment successful! Your account has been activated.']);
        
       // $payments = Payment::where('transactionid',$ref)->first();
       // $payments -> trackingid = $trackingid;
       // $payments -> status = 'PENDING';
        //$payments -> save();
        //go back home
       // $payments=Payment::all();
        //return view('payments.business.home', compact('payments'));

        //return view('admin.incomes.index');
    }



    //This method just tells u that there is a change in pesapal for your transaction..
    //u need to now query status..retrieve the change...CANCELLED? CONFIRMED?
    /*public function paymentconfirmation(Request $request)
    {
        $trackingid = $request->input('pesapal_transaction_tracking_id');
        $merchant_reference = $request->input('pesapal_merchant_reference');
        $pesapal_notification_type= $request->input('pesapal_notification_type');

        //use the above to retrieve payment status now..
        $this->checkpaymentstatus($trackingid,$merchant_reference,$pesapal_notification_type);
    }
    //Confirm status of transaction and update the DB
    public function checkpaymentstatus($trackingid,$merchant_reference,$pesapal_notification_type){
        $status=Pesapal::getMerchantStatus($merchant_reference);
        $payments = Payment::where('trackingid',$trackingid)->first();
        $payments -> status = $status;
        $payments -> payment_method = "PESAPAL";//use the actual method though...
        $payments -> save();
        return "success";
    }*/
}
