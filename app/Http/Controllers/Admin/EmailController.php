<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEmailRequest;
use App\Http\Requests\StoreEmailRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Models\Email;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Mail;
use App\Mail\Mailer;
use App\Mail\MailerAttachment;


class EmailController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('email_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Email::query()->select(sprintf('%s.*', (new Email)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'email_show';
                $editGate      = 'email_edit';
                $deleteGate    = 'email_delete';
                $crudRoutePart = 'emails';

                return view('partials.datatablesActions', compact(
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
            $table->editColumn('list', function ($row) {
                return $row->list ? Email::LIST_SELECT[$row->list] : '';
            });
            $table->editColumn('subject', function ($row) {
                return $row->subject ? $row->subject : "";
            });
            $table->editColumn('custom_list', function ($row) {
                return $row->custom_list ? $row->custom_list : "";
            });
            $table->editColumn('message', function ($row) {
                return $row->message ? strip_tags(str_replace('<', ' <', $row->message)) : '';
            });

            
            $table->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at : "";
            });
            $table->editColumn('image', function ($row) {
                if ($photo = $row->image) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('attachments', function ($row) {
                if (!$row->attachments) {
                    return '';
                }

                $links = [];

                foreach ($row->attachments as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>';
                }

                return implode(', ', $links);
            });

            $table->rawColumns(['actions', 'placeholder', 'image', 'attachments']);

            return $table->make(true);
        }

        return view('admin.emails.index');
    }

    public function create()
    {
        abort_if(Gate::denies('email_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $members = User::all()->pluck('email');

        $bcc = json_decode($members);

        return view('admin.emails.create', compact('members'));
    }

    public function store(StoreEmailRequest $request)
    {
        $email = Email::create($request->all());
        $upload=0;
        if ($request->input('image', false)) {
            $upload=$email->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
        }

        foreach ($request->input('files', []) as $file) {
            $upload=$email->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('files');
        }

        if ($media = $request->input('ck-media', false)) {
            $upload=Media::whereIn('id', $media)->update(['model_id' => $email->id]);
        }

        $this->send($request,$upload->id); 
        

        return redirect()->route('admin.emails.index');
    }

    public function send(Request $request, $email_id)
    {
        $this->validate($request, [
        'subject'     =>  'required',
        'message' =>  'required'
        ]);

        //IMAGE REFERENCE REQUIRES SYMLINKS!!!!!
        //ln -s /home/kigcre5/crm/storage/tmp/uploads  /home/kigcre5/public_html/crm/uploads

        $image_url=env('APP_URL').'/storage/'.$email_id."/".$request->input('image');
        
      

    /*  public const LIST_SELECT = [
        '1' => 'CUSTOM LIST',
        '2' => 'ALL MEMBERS (ACTIVE)',
        '3' => 'PAID MEMBERS',
        '4' => 'UNPAID MEMBERS',
        '5' => 'INACTIVE MEMBERS',
        ]; 

        public const STATUS_SELECT = [
        '1' => 'UNPAID',
        '2' => 'PAID',
        '3' => 'BALANCE',
        '4' => 'INACTIVE',
    ];
    */

        $bcc="";
        $mail_list="";
        $batch_size = 400; //Set Email Limit 400
        $delay = 70;  // in minutes 

        switch ($request->list) {
            case 1: // CUSTOM LIST
                $mail_list = explode(',', $request->custom_list);
                break;
            case 2: // ALL MEMBERS (ACTIVE)
                $members = User::all()->pluck('email');
                $mail_list = json_decode($members);
                break;
            case 3: // PAID MEMBERS
                $members = User::where('status', 2)->pluck('email');
                $mail_list = json_decode($members);
                break;
            case 4: //UNPAID MEMBERS
                $members = User::where('status', 3)->orWhere('status', '1')->pluck('email');
                $mail_list = json_decode($members);
                break;
            case 5: //INACTIVE MEMBERS
                $members = User::where('status', 4)->pluck('email');
                $mail_list = json_decode($members);             
                break;
        }

        $file_url=array();  
        foreach ($request->input('attachments', []) as $file) {
                array_push($file_url, storage_path('tmp/uploads/'.$file));
        }


        if($file_url!=""){

            $data = array(
                'subject'      =>  $request->subject,
                'message'   =>   $request->message,
                'image' =>  $image_url,
                'attachment'  => $file_url
            );

            $member_count = intval(count($mail_list));
            if ($member_count > $batch_size){

                $members_1 = array_slice($mail_list, 0, intval($member_count/2));

                Mail::cc('membership@kenyapaediatric.org')->bcc($members_1)->send(new MailerAttachment($data));
                //Mail::bcc($members_1)->send(new MailerAttachment($data));

                $batches = ceil($member_count/$batch_size);
                for($i=1; $i<=$batches; $i++){
                    $start = intval( $batch_size * $i);
                    $stop = intval( $start + $batch_size );
                    $when = intval( $delay * $i );
                    $members = array_slice($mail_list, $start , $stop);
                   Mail::cc('membership@kenyapaediatric.org')->bcc($members)->later(now()->addMinutes($when), new MailerAttachment($data));
                    //Mail::bcc($members)->later(now()->addMinutes($when), new MailerAttachment($data));

                }    
                     
            }else{   
                Mail::cc('membership@kenyapaediatric.org')->bcc($mail_list)->send(new MailerAttachment($data));
                //Mail::bcc($mail_list)->send(new Mailer($data));
           
            }

        }else{

            $data = array(
                'subject'      =>  $request->subject,
                'message'   =>   $request->message,
                'image' =>  $image_url
            );

            $member_count = intval(count($mail_list));
            
            if ($member_count > $batch_size){
                $members_1 = array_slice($mail_list, 0, intval($member_count/2));
                Mail::cc('membership@kenyapaediatric.org')->bcc($members_1)->send(new Mailer($data));
                //Mail::bcc($members_1)->send(new Mailer($data));

                $batches = ceil($member_count/$batch_size);
                for($i=1; $i<=$batches; $i++){
                    $start = intval( $batch_size * $i);
                    $stop = intval( $start + $batch_size );
                    $when = intval( $delay * $i );
                    $members = array_slice($mail_list, $start , $stop);
                    Mail::cc('membership@kenyapaediatric.org')->bcc($members)->later(now()->addMinutes($when),new Mailer($data));
                    //Mail::bcc($members)->later(now()->addMinutes($when),new Mailer($data));
                }       

            }else{

                Mail::cc('membership@kenyapaediatric.org')->bcc($mail_list)->send(new Mailer($data));
                //Mail::bcc($mail_list)->send(new Mailer($data));
           
            }

           

        }


       
        return redirect()->route('admin.emails.index');

    }
    public function edit(Email $email)
    {
        abort_if(Gate::denies('email_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.emails.edit', compact('email'));
    }

    public function update(UpdateEmailRequest $request, Email $email)
    {
        $email->update($request->all());

        if ($request->input('image', false)) {
            if (!$email->image || $request->input('image') !== $email->image->file_name) {
                if ($email->image) {
                    $email->image->delete();
                }

                $email->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }
        } elseif ($email->image) {
            $email->image->delete();
        }

        if (count($email->attachments) > 0) {
            foreach ($email->attachments as $media) {
                if (!in_array($media->file_name, $request->input('attachments', []))) {
                    $media->delete();
                }
            }
        }

        $media = $email->attachments->pluck('file_name')->toArray();

        foreach ($request->input('attachments', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $email->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('attachments');
            }
        }

        return redirect()->route('admin.emails.index');
    }

    public function show(Email $email)
    {
        abort_if(Gate::denies('email_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.emails.show', compact('email'));
    }

    public function destroy(Email $email)
    {
        abort_if(Gate::denies('email_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $email->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmailRequest $request)
    {
        Email::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('email_create') && Gate::denies('email_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Email();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
