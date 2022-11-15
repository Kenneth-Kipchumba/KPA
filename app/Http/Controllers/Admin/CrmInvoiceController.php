<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCrmInvoiceRequest;
use App\Http\Requests\StoreCrmInvoiceRequest;
use App\Models\CrmInvoice;
use App\Models\User;
use App\Models\Rate;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Mail;
use App\Mail\MailerAttachment;

//Laravel Invoices 
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class CrmInvoiceController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('crm_invoice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CrmInvoice::with(['member'])->select(sprintf('%s.*', (new CrmInvoice)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'crm_invoice_show';
                $editGate      = 'crm_invoice_edit';
                $deleteGate    = 'crm_invoice_delete';
                $crudRoutePart = 'crm-invoices';

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

            $table->editColumn('invoice_no', function ($row) {
                return $row->invoice_no ? $row->invoice_no : "";
            });
            $table->addColumn('member_name', function ($row) {
                return $row->member ? $row->member->member_no." - ".$row->member->name : '';
            });

            $table->editColumn('member.member_no', function ($row) {
                return $row->member ? (is_string($row->member) ? $row->member : $row->member->member_no) : '';
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : "";
            });
            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : "";
            });


            $table->editColumn('discount', function ($row) {
                return $row->discount ? $row->discount : "";
            });
            $table->editColumn('items', function ($row) {
                return $row->items ? $row->items : "";
            });
            $table->editColumn('file', function ($row) {
                return $row->file ? $row->file : "";
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? CrmInvoice::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'member']);

            return $table->make(true);
        }

        $members = User::all()->where('status', '=', '2')->pluck('id'); // Status UNPAID
        $members_email = User::all()->where('status', '=', '3')->pluck('id'); // Status UNPAID

        return view('admin.crmInvoices.index', compact('members','members_email'));
    }

    public function create()
    {
        abort_if(Gate::denies('crm_invoice_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $members = User::select(DB::raw('CONCAT(member_no, " - ", name) AS full_name, id'))
        ->pluck('full_name', 'id')->prepend(trans('global.pleaseSelect'), '');
 
        //$products = Product::with('clients')->where('status', 1)->get();
        $products = Rate::all();

        $new_id=str_pad(CrmInvoice::max('id')+1, 5, '0', STR_PAD_LEFT);

        $new_id_no = 'IN-'.date("Y")."-".$new_id;

        return view('admin.crmInvoices.create', compact('members', 'products', 'new_id_no'));

        $members = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.crmInvoices.create', compact('members'));

    }
    public function generate(){


        abort_if(Gate::denies('crm_invoice_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $members = User::select(DB::raw('CONCAT(member_no, " - ", name) AS full_name, id'))
        ->pluck('full_name', 'id')->prepend(trans('global.pleaseSelect'), '');
 
        $members = User::all()->where('status', '=', '2');
        $count = 0;
        foreach($members as $member) {

            $this->invoice($member->id);
            $count ++;
        }

        return redirect()->route('admin.crm-invoices.index')->with('message', $count.' '.__('global.generate_invoice_success'));

    }

    public function invoice(Request $request){

        $member = User::all()->find($request->id);
        
        if($member){

            $new_id=str_pad(CrmInvoice::max('id')+1, 5, '0', STR_PAD_LEFT);
            $new_id_no = 'IN-'.date("Y")."-".$new_id;
    
            $rate = Rate::all()->find(4);
    
            $customer = new Party([
                'name'          => $member->member_no." - ".$member->name,
                'code'          => $new_id_no,
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
            
            $invoice = Invoice::make()
            ->buyer($customer)
            ->seller($seller)
            ->addItems($invoice_items)
            ->totalDiscount(0) 
            ->taxableAmount($invoice_total) 
            ->filename('INVOICE-'.$new_id_no)
            ->logo(asset('img/logo_kpa.png'))
            ->save('public');
    
            $invoice_url = $invoice->url();
    
            $data['discount'] = 0;
    
            $data['paid'] = 0;
    
            $data['member_id'] = $member->id;
    
            $data['date'] = date('d-m-Y');
    
            $data['invoice_no'] = $new_id_no;
    
            $data['file'] =  $invoice_url;
    
            $data['amount'] = $invoice_total;
    
            $data['balance'] =  floatval($data['amount']);
    
            $data['status'] = 2;
            
            $crmInvoice = CrmInvoice::create($data);
    
            $member->status = 8;
    
            $member->save();
        }


        return redirect()->route('admin.crm-invoices.index')->with('message', __('global.generate_invoice_success'));

  
    } 

    public function email(Request $request){ 

        $invoice = DB::table('crm_invoices')
        ->where('member_id', '=', $request->id)
        ->first();
        //$bcc = [$member->email,'membership@kenyapaediatric.org'];

        if($invoice){

            $member = User::all()->find($request->id);

            $bcc = $member->email;
 
            $subject="KPA Invoice No. ".$invoice->invoice_no;
    
            $items=json_decode($invoice->items, true);
    
            $message="Dear Member, Please find attached your Membership Invoice. <br/><br/>";
            $message.="<b>Member No.</b>: &nbsp; ". $member->member_no."<br/>";
            $message.="<b>Email:</b> &nbsp; ". $member->email."<br/>";
            $message.="<b>Names:</b> &nbsp;". $member->name."<br/>";
            $message.="<b>Amount:</b> &nbsp;". $invoice->amount."<br/>";
            $message.="Regards.";
    
            $data = array(
                'subject'      =>  $subject,
                'message'   =>   $message,
                'image'   =>   asset('img/email_header.png'),
                'attachment'  =>    $invoice->file
            );
    
            Mail::bcc($bcc)->send(new MailerAttachment($data));

                
            $member->status = 5;
    
            $member->save();
            
        }

        
        return redirect()->route('admin.emails.index');

    }
    public function store(StoreCrmInvoiceRequest $request)
    {

        $data = $request->all();
        $member = DB::table('users')->find($data['member_id']);

        $customer = new Party([
            'name'          => $member->member_no." ".$member->name,
            'code'          => $data['invoice_no'],
        ]);

        $seller = new Party([
            'name'          => 'Kenya Paediatric Association',
            'address'       => 'KMA Center 3rd Floor, Office suite 301, Upper Hill, Mara Road, Nairobi P.O.Box 45820 00100 GPO Nairobi, Kenya',
            'phone'         => 'Email: membership@kenyapaediatric.org  Tel: +254 020 2725309 / 2726298 Cell: +254 726 161590'
        ]);

        $items = json_decode($data['items'], true);
        $invoice_items = [];
        $invoice_total = 0;
        foreach($items as $item) {

            $line =  (new InvoiceItem())->title($item['name'])->pricePerUnit($item['price'])->quantity($item['qty']);
            $invoice_total += $item['price'];
            if($item['name']!=""){array_push($invoice_items, $line);}
        }
            

        $invoice = Invoice::make()
            ->buyer($customer)
            ->seller($seller)
            ->addItems($invoice_items)
            ->totalDiscount($data['discount']) 
            ->taxableAmount($invoice_total) 
            ->filename('INVOICE-'.$data['invoice_no'])
            ->logo(asset('img/logo_kpa_full.png'))
            ->save('public');

        $invoice_url = $invoice->url();

        $data['file'] =  $invoice_url;

        $data['balance'] =  floatval($data['amount']);

        $data['status'] = 1;
        
        $crmInvoice = CrmInvoice::create($data);
        
        return redirect()->route('admin.crm-invoices.index');

    }

    public function edit(CrmInvoice $crmInvoice)
    {
        
        //abort_if(Gate::denies('crmInvoice_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //$members = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        //$invoices = CrmInvoice::all()->pluck('invoice_no', 'id')->prepend(trans('global.pleaseSelect'), '');
        //$crmInvoice_categories = IncomeCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        //$crmInvoice->load('member', 'invoice', 'crmInvoice_category');
        //return view('admin.crmInvoices.edit', compact('members', 'invoices', 'crmInvoice_categories', 'crmInvoice'));

        $bcc = [$crmInvoice->member->email,'membership@kenyapaediatric.org'];

        $subject="KPA Invoice No. ".$crmInvoice->invoice_no;

        $items=json_decode($crmInvoice->items, true);

        $files=[];  
        
        array_push($files, $crmInvoice->file);
        

        $message="Dear Member, Please find attached your Membership Invoice. <br/><br/>";
        $message.="<b>Member No.</b>: &nbsp; ". $crmInvoice->member->member_no."<br/>";
        $message.="<b>Email:</b> &nbsp; ". $crmInvoice->member->email."<br/>";
        $message.="<b>Names:</b> &nbsp;". $crmInvoice->member->name."<br/>";
        $message.="<b>Amount:</b> &nbsp;". $crmInvoice->amount."<br/>";
        $message.="Regards.";

        $data = array(
            'subject'      =>  $subject,
            'message'   =>   $message,
            'image'   =>   asset('img/email_header.png'),
            'attachment'  =>    $files
        );

        Mail::bcc($bcc)->send(new MailerAttachment($data));

        return redirect()->route('admin.crm-invoices.index');


    }

    public function show(CrmInvoice $crmInvoice)
    {
        abort_if(Gate::denies('crm_invoice_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crmInvoice->load('member', 'invoiceIncomes');

        return view('admin.crmInvoices.show', compact('crmInvoice'));
    }

    public function destroy(CrmInvoice $crmInvoice)
    {
        abort_if(Gate::denies('crm_invoice_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crmInvoice->delete();

        return back();
    }

    public function massDestroy(MassDestroyCrmInvoiceRequest $request)
    {
        CrmInvoice::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
