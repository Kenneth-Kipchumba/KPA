<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySmsRequest;
use App\Http\Requests\StoreSmsRequest;
use App\Http\Requests\UpdateSmsRequest;
use App\Models\Sms;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use AfricasTalking\SDK\AfricasTalking;

class SmsController extends Controller
{
    use CsvImportTrait;

    private $username = 'PaedsKPA'; 
    private $apiKey   = '7ca5e7d7f73273a0a75ca539f0c21830a0da4422d48d6b74046006cc1602ddb5'; 

        
    
    public function index(Request $request)
    {

        abort_if(Gate::denies('sms_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Sms::query()->select(sprintf('%s.*', (new Sms())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'sms_show';
                $editGate = 'sms_edit';
                $deleteGate = 'sms_delete';
                $crudRoutePart = 'sms';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('list', function ($row) {
                return $row->list ? Sms::LIST_SELECT[$row->list] : '';
            });
            $table->editColumn('message', function ($row) {
                return $row->message ? $row->message : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.sms.index');
    }

    public function create()
    {
        abort_if(Gate::denies('sms_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $balance = 0;

        $AT = new AfricasTalking($this->username, $this->apiKey);
 
        $application = $AT->application()->fetchApplicationData()['data'];

        $balance_unrounded = $application->UserData->balance;

        $balance_array = explode(" ",$balance_unrounded);

        $balance = $balance_array[0]." ".number_format(round((float)$balance_array[1],2),2);

        return view('admin.sms.create', compact('balance'));
    }

    public function store(StoreSmsRequest $request)
    {
        $data = $request->all();

        $AT = new AfricasTalking($this->username, $this->apiKey);

        $sms_AT = $AT->sms();
    
        $to="";

        switch ($request->list) {
            case 1:
                $to = explode(",",$data['custom_list']);
                break;
            case 2:
                $members = User::all()->pluck('phone');
                $to = json_decode($members);
                break;
            case 3:
                $members = User::where('status', 2)->pluck('phone');
                $to = json_decode($members);
                break;
            case 4:
                $members = User::where('status', 3)->orWhere('status', '1')->pluck('phone');
                $to = json_decode($members);
                break;
            case 5:
                $members = User::where('status', 4)->pluck('phone');
                $to = json_decode($members);
                break;
        }
        

        $result   = $sms_AT->send([
            'to'      => $to,
            'message' => $data['message'],
            'from'    => 'PaedsKPA'
        ]);
        
        $sms = Sms::create($request->all());

        return redirect()->route('admin.sms.index', compact('result'));
    }

    public function edit(Sms $sms)
    {
        abort_if(Gate::denies('sms_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sms.edit', compact('sms'));
    }

    public function update(UpdateSmsRequest $request, Sms $sms)
    {
        $sms->update($request->all());

        return redirect()->route('admin.sms.index');
    }

    public function show(Sms $sms)
    {
        abort_if(Gate::denies('sms_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sms.show', compact('sms'));
    }

    public function destroy(Sms $sms)
    {
        abort_if(Gate::denies('sms_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sms->delete();

        return back();
    }

    public function massDestroy(MassDestroySmsRequest $request)
    {
        Sms::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
