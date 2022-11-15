<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyIncomeRequest;
use App\Http\Requests\StoreIncomeRequest;
use App\Http\Requests\UpdateIncomeRequest;
use App\Models\CrmInvoice;
use App\Models\Income;
use App\Models\IncomeCategory;
use App\Models\User;
use App\Models\Rate;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailerAttachment;

use Illuminate\Support\Facades\DB;

//Laravel Invoices 
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('income_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Income::with(['member', 'invoice', 'income_category'])->select(sprintf('%s.*', (new Income)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'income_show';
                $editGate      = 'income_edit';
                $deleteGate    = 'income_delete';
                $crudRoutePart = 'incomes';

                return view('partials.datatablesActionsEmail', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });

            $table->editColumn('receipt_no', function ($row) {
                return $row->receipt_no ? $row->receipt_no : "";
            });
            $table->addColumn('member_name', function ($row) {
                return $row->member ? $row->member->name : '';
            });
            $table->addColumn('status', function ($row) {
                return $row->member ? User::STATUS_SELECT[$row->member->status] : '';
            });
            $table->editColumn('member.member_no', function ($row) {
                return $row->member ? (is_string($row->member) ? $row->member : $row->member->member_no) : '';
            });
            $table->addColumn('invoice_invoice_no', function ($row) {
                return $row->invoice ? $row->invoice->invoice_no : '';
            });

            $table->editColumn('invoice.invoice_no', function ($row) {
                return $row->invoice ? (is_string($row->invoice) ? $row->invoice : $row->invoice->invoice_no) : '';
            });
            $table->editColumn('invoice.amount', function ($row) {
                return $row->invoice ? (is_string($row->invoice) ? $row->invoice : $row->invoice->amount) : '';
            });
            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : "";
            });
            $table->addColumn('income_category_name', function ($row) {
                return $row->income_category ? $row->income_category->name : '';
            });

            $table->editColumn('mode', function ($row) {
                return $row->mode ? Income::MODE_SELECT[$row->mode] : '';
            });
            $table->editColumn('transaction_no', function ($row) {
                return $row->transaction_no ? $row->transaction_no : "";
            });
            $table->editColumn('items', function ($row) {
                return $row->items ? $row->items : "";
            });
            $table->editColumn('file', function ($row) {
                return $row->file ? $row->file : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'member', 'invoice', 'income_category']);

            return $table->make(true);
        }

        return view('admin.incomes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('income_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $members = User::select(DB::raw('CONCAT(member_no, " - ", name) AS full_name, id'))
        ->pluck('full_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $income_categories = IncomeCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $invoices = CrmInvoice::with('member')->whereColumn('amount', '>', 'paid')->get();

        $products = Rate::all();
        
        $new_id=str_pad(Income::max('id')+1, 5, '0', STR_PAD_LEFT);

        $new_id_no = 'RE-'.date("Y")."-".$new_id;

        return view('admin.incomes.create', compact('members', 'products', 'invoices', 'income_categories', 'new_id_no'));    
    }

    public function store(StoreIncomeRequest $request)
    {

        $data = $request->all();

        $member = User::all()->find($data['member_id']);  

        if($data['invoice_id']!=0){

            $invoice =  CrmInvoice::find($data['invoice_id']);

            
            $invoice->paid =  floatval($invoice->paid) + floatval($data['amount']);

            $invoice->balance = floatval($invoice->balance) - floatval($data['amount']);

            $invoice->paid = $data['amount'];
    
            if( $invoice->balance > 0 ){

                $invoice->status = 3;
                
            }else{
                $invoice->status = 2;
            }

            if($invoice->paid>=$invoice->amount){

                $invoice->status=2; 
                
                $invoice->save();

                $member->status = 2;
        
                $member->save();
            }
    
           
        }
        
        //$items = json_decode($invoice->items, true);
        $items = json_decode($data['items'], true);

        $invoice_items = [];
        $invoice_total = 0;
        foreach($items as $item) {

            $line =  (new InvoiceItem())->title($item['name'])->pricePerUnit($item['price'])->quantity($item['qty']);
            $invoice_total += $item['price'];
            if($item['name']!=""){array_push($invoice_items, $line);}
        }

        $data['balance'] = floatval($invoice_total) - floatval($data['amount']);

        if( floatval($data['balance']) > 0 ){

            $data['status'] = 3;
            
        }else{
            $data['status'] = 2;
        }
         

        $customer = new Party([
            'name'          => $member->member_no." - ".$member->name,
            'code'          => $data['receipt_no'],
            'custom_fields' => [
                //'invoice_no' => $invoice->invoice_no,
                'receipt_no' => $data['receipt_no'],
                'paid' => $data['amount'],
                'balance' => $data['balance'],
                'mode' => $data['mode'],
                'transaction_no' => $data['transaction_no']
            ],
        ]);

        $seller = new Party([
            'name'          => 'Kenya Paediatric Association',
            'address'       => 'KMA Center 3rd Floor, Office suite 301, Upper Hill, Mara Road, Nairobi P.O.Box 45820 00100 GPO Nairobi, Kenya',
            'phone'         => 'Email: membership@kenyapaediatric.org  Tel: +254 020 2725309 / 2726298 Cell: +254 726 161590'
        ]);



        $receipt = Invoice::make()
            ->buyer($customer)
            ->seller($seller)
            ->addItems($invoice_items)
            //->totalDiscount($invoice->discount) 
            ->totalAmount($data['amount'])
            ->filename('RECEIPT-'.$data['receipt_no'])
            ->logo(asset('img/logo_kpa_full.png'))
            ->template('default_receipt')
            ->save('public');

        $receipt_url = $receipt->url();

        $data['file'] =  $receipt_url;
        
        $income = Income::create($data);

        $this->edit($income);

        return redirect()->route('admin.incomes.index');


    }

    public function send(Income $income){

        $bcc = $income->member->email.",membership@kenyapaediatric.org";

        $subject="KPA Receipt No. 0001";

        $message="Sample message";

        $data = array(
            'subject'      =>  $subject,
            'message'   =>   $message,
            'image'   =>   public_path('img/kpa_logo.png')
        );

        Mail::bcc($bcc)->send(new MailerAttachment($data));

        return redirect()->route('admin.emails.index');
    }

    public function edit(Income $income)
    {
        
        //abort_if(Gate::denies('income_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //$members = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        //$invoices = CrmInvoice::all()->pluck('invoice_no', 'id')->prepend(trans('global.pleaseSelect'), '');
        //$income_categories = IncomeCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        //$income->load('member', 'invoice', 'income_category');
        //return view('admin.incomes.edit', compact('members', 'invoices', 'income_categories', 'income'));

        $bcc = [$income->member->email,'membership@kenyapaediatric.org'];

        $subject="KPA Receipt No. ".$income->receipt_no;

        $items=json_decode($income->items, true);

        $message="Dear Member, Please find attached your Payment Receipt. <br/><br/>";
        $message.="<b>Member No.</b>: &nbsp; ". $income->member->member_no."<br/>";
        $message.="<b>Email:</b> &nbsp; ". $income->member->email."<br/>";
        $message.="<b>Names:</b> &nbsp;". $income->member->name."<br/>";
        $message.="<b>Details:</b> &nbsp; ".$items[0]["name"]."<br/>"; 
        $message.="<b>Amount:</b> &nbsp;". $income->amount."<br/>";
        $message.="<b>Transaction No: </b>&nbsp;". $income->transaction_no."<br/><br/>";
        $message.="Regards.";

        $file_url=array();  
        array_push($file_url, $income->file);
        

        $data = array(
            'subject'      =>  $subject,
            'message'   =>   $message,
            'image'   =>   public_path('img/kpa_logo.png'),
            'attachment'  =>    $file_url
        );

        Mail::bcc($bcc)->send(new MailerAttachment($data));

        return redirect()->route('admin.incomes.index');


    }

    public function update(UpdateIncomeRequest $request, Income $income)
    {
        $income->update($request->all());

        return redirect()->route('admin.incomes.index');
    }

    public function show(Income $income)
    {
        abort_if(Gate::denies('income_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $income->load('member', 'invoice', 'income_category');

        return view('admin.incomes.show', compact('income'));
    }

    public function destroy(Income $income)
    {
        abort_if(Gate::denies('income_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $income->delete();

        return back();
    }

    public function massDestroy(MassDestroyIncomeRequest $request)
    {
        Income::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
