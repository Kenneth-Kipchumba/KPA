<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Location;
use App\Models\Role;
use App\Models\Specialization;
use App\Models\User;
use App\Models\CrmInvoice;
use App\Models\Income;
use App\Models\IncomeCategory;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailerAttachment;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

use LaravelDaily\Invoices\Classes\Party;

use PDF;

class UsersController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = User::with(['specialization', 'location', 'roles'])->select(sprintf('%s.*', (new User())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'user_show';
                $editGate = 'user_edit';
                $deleteGate = 'user_delete';
                $crudRoutePart = 'users';

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
            $table->editColumn('member_no', function ($row) {
                return $row->member_no ? $row->member_no : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : '';
            });
            $table->editColumn('board_reg_no', function ($row) {
                return $row->board_reg_no ? $row->board_reg_no : '';
            });
            $table->editColumn('designation', function ($row) {
                return $row->designation ? User::DESIGNATION_SELECT[$row->designation] : '';
            });
            $table->addColumn('specialization_name', function ($row) {
                return $row->specialization ? $row->specialization->name : '';
            });

            $table->editColumn('specialization_other', function ($row) {
                return $row->specialization_other ? $row->specialization_other : '';
            });
            $table->editColumn('workstation', function ($row) {
                return $row->workstation ? $row->workstation : '';
            });
            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : '';
            });
            $table->addColumn('location_name', function ($row) {
                return $row->location ? $row->location->name : '';
            });

            $table->editColumn('status', function ($row) {
                return $row->status ? User::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('id_no', function ($row) {
                return $row->id_no ? $row->id_no : '';
            });
            $table->editColumn('postal_address', function ($row) {
                return $row->postal_address ? $row->postal_address : '';
            });
            $table->editColumn('postal_code', function ($row) {
                return $row->postal_code ? $row->postal_code : '';
            });

            $table->editColumn('approved', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->approved ? 'checked' : null) . '>';
            });
            $table->editColumn('roles', function ($row) {
                $labels = [];
                foreach ($row->roles as $role) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $role->title);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'specialization', 'location', 'approved', 'roles']);

            return $table->make(true);
        }

        $specializations = Specialization::get();
        $locations       = Location::get();
        $roles           = Role::get();

        return view('admin.users.index', compact('specializations', 'locations', 'roles'));
    }

    /**
     * Members List to be embeded on the main website
     */
    public function our_members()
    {
        $users = new User;

        //$data['active_members'] = $users->where('status', 2)->get();
        $data['our_members'] = $users->paginate(20);

        return view('admin.users.our_members', $data);
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $specializations = Specialization::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $locations = Location::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $roles = Role::all()->pluck('title', 'id');

        $new_id=str_pad(User::count(), 3, '0', STR_PAD_LEFT); 

        $new_id_no = 'KPA/'.$new_id;
        
        return view('admin.users.create', compact('specializations', 'locations', 'roles', 'new_id_no'));
   }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));
        if ($request->input('photo', false)) {
            $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $user->id]);
        }

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $specializations = Specialization::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $locations = Location::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $roles = Role::all()->pluck('title', 'id');

        $user->load('specialization', 'location', 'roles');

        return view('admin.users.edit', compact('specializations', 'locations', 'roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));
        if ($request->input('photo', false)) {
            if (!$user->photo || $request->input('photo') !== $user->photo->file_name) {
                if ($user->photo) {
                    $user->photo->delete();
                }
                $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($user->photo) {
            $user->photo->delete();
        }

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('specialization', 'location', 'roles', 'studentTestResults', 'memberIncomes', 'memberCrmInvoices', 'memberEventAttendances', 'studentsCourses');


        $invoices = CrmInvoice::where('member_id', $user->id )->get(['crm_invoices.*'])->toArray();

        $incomes = Income::where('member_id', $user->id )->get(['entry_date AS date','receipt_no AS invoice_no', 'incomes.*'])->toArray();

        $results = array_merge($invoices, $incomes);
        usort($results, function($a,$b) { 
            return strtotime($a['created_at']) - strtotime($b['created_at']);
        });

		$object = json_decode(json_encode($results), FALSE);
        $incomes = json_decode(json_encode($incomes), FALSE);
		
		$account = 0;
		foreach ($object as $transaction) {    
			if(isset($transaction->receipt_no)){
				$account = $account + floatval($transaction->amount);
				$transaction->amount = number_format($transaction->amount, 2);
			}elseif(isset($transaction->invoice_no)){
				$account = $account - floatval($transaction->amount);
				$transaction->amount = number_format($transaction->amount, 2);
			}
			$transaction->account_balance = number_format($account, 2);
		} 
		

		$array = json_encode($object);  
		


        $seller = new Party([
            'name'          => 'Kenya Paediatric Association',
            'address'       => 'KMA Center 3rd Floor, Office suite 301, Upper Hill, Mara Road, Nairobi P.O.Box 45820 00100 GPO Nairobi, Kenya',
            'phone'         => 'Email: membership@kenyapaediatric.org  Tel: +254 020 2725309 / 2726298 Cell: +254 726 161590'
        ]);

        $customer = new Party([
            'no'            => $user->member_no,
            'name'          => $user->member_no." - ".$user->name
        ]);

        $data = [
            'title' => 'Financial Statement',
            'date' => date('d-M-Y'),
            'seller' => $seller,
            'buyer' => $customer,
            'invoices' => $object,
            'incomes' => $incomes,
			'results' => $array,
            'logo' => asset('img/logo_kpa_full.png')
        ];
           
        $pdf = PDF::loadView('vendor/invoices/templates/statement', $data);  
     
        $pdf->save(storage_path('app/public/filename.pdf'));

        return view('admin.users.show', compact('user', 'pdf'));
    }

    public function send(Request $request){

        
        $user = User::find($request->id);

        $bcc = [$user->email,'membership@kenyapaediatric.org'];

        $subject="KPA Financial Statement as of. ".date('d-M-Y');

        $message="Dear Member, Please find attached yourFinancial Statement as of ".date('d-M-Y').". <br/><br/>";
        $message.="<b>Member No.</b>: &nbsp; ". $user->member_no."<br/>";
        $message.="<b>Email:</b> &nbsp; ". $user->email."<br/>";
        $message.="<b>Names:</b> &nbsp;". $user->name."<br/>";

        $message.="Regards.";

        $file_url=array();  
        array_push($file_url, storage_path('app/public/filename.pdf'));
        

        $data = array(
            'subject'      =>  $subject,
            'message'   =>   $message,
            'image'   =>   public_path('img/kpa_logo.png'),
            'attachment'  =>    $file_url
        );

        Mail::bcc($bcc)->send(new MailerAttachment($data));

        return redirect()->route('admin.users.index', compact('user'));



    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('user_create') && Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new User();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
