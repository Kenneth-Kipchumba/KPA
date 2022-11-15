<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyWebinarRequest;
use App\Http\Requests\StoreWebinarRequest;
use App\Http\Requests\UpdateWebinarRequest;
use App\Models\Specialization;
use App\Models\Webinar;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class WebinarsController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;


    public function index(Request $request)
    {
        abort_if(Gate::denies('webinar_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Webinar::with(['specialization'])->select(sprintf('%s.*', (new Webinar())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'webinar_show';
                $editGate = 'webinar_edit';
                $deleteGate = 'webinar_delete';
                $crudRoutePart = 'webinars';

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

            $table->editColumn('date_time', function ($row) {
                return $row->date_time ? date('l, d F Y, h:i A' ,strtotime($row->date_time)) : '';
            });

            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('link', function ($row) {
                return $row->link ? $row->link : '';
            });
            $table->editColumn('video', function ($row) {
                return $row->video ? $row->video : '';
            });
            $table->addColumn('specialization_name', function ($row) {
                return $row->specialization ? $row->specialization->name : '';
            });

            $table->editColumn('image', function ($row)
            {
                if ($photo = $row->image)
                {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });

            $table->rawColumns(['actions', 'placeholder', 'specialization', 'image']);

            return $table->make(true);
        }

        $specializations = Specialization::get();

        $webinars = Webinar::orderBy('date_time', 'DESC')->get();

        return view('admin.webinars.index', compact('specializations','webinars'));
    }

    public function create()
    {
        abort_if(Gate::denies('webinar_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $specializations = Specialization::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.webinars.create', compact('specializations'));
    }

    public function store(StoreWebinarRequest $request)
    {
        $webinar = Webinar::create($request->all());

        if ($request->input('image', false)) {
            $webinar->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $webinar->id]);
        }

        return redirect()->route('admin.webinars.index');
    }

    public function edit(Webinar $webinar)
    {
        abort_if(Gate::denies('webinar_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $specializations = Specialization::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $webinar->load('specialization');

        return view('admin.webinars.edit', compact('specializations', 'webinar'));
    }

    public function update(UpdateWebinarRequest $request, Webinar $webinar)
    {
        $webinar->update($request->all());

        if ($request->input('image', false)) {
            if (!$webinar->image || $request->input('image') !== $webinar->image->file_name) {
                if ($webinar->image) {
                    $webinar->image->delete();
                }
                $webinar->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($webinar->image) {
            $webinar->image->delete();
        }

        return redirect()->route('admin.webinars.index');
    }

    public function show(Webinar $webinar)
    {
        abort_if(Gate::denies('webinar_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $webinar->load('specialization');

        return view('admin.webinars.show', compact('webinar'));
    }

    public function destroy(Webinar $webinar)
    {
        abort_if(Gate::denies('webinar_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $webinar->delete();

        return back();
    }

    public function massDestroy(MassDestroyWebinarRequest $request)
    {
        Webinar::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('webinar_create') && Gate::denies('webinar_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Webinar();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
