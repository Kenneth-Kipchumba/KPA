<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySpecializationRequest;
use App\Http\Requests\StoreSpecializationRequest;
use App\Http\Requests\UpdateSpecializationRequest;
use App\Models\Specialization;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SpecializationController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('specialization_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Specialization::query()->select(sprintf('%s.*', (new Specialization())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'specialization_show';
                $editGate = 'specialization_edit';
                $deleteGate = 'specialization_delete';
                $crudRoutePart = 'specializations';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.specializations.index');
    }

    public function create()
    {
        abort_if(Gate::denies('specialization_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.specializations.create');
    }

    public function store(StoreSpecializationRequest $request)
    {
        $specialization = Specialization::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $specialization->id]);
        }

        return redirect()->route('admin.specializations.index');
    }

    public function edit(Specialization $specialization)
    {
        abort_if(Gate::denies('specialization_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.specializations.edit', compact('specialization'));
    }

    public function update(UpdateSpecializationRequest $request, Specialization $specialization)
    {
        $specialization->update($request->all());

        return redirect()->route('admin.specializations.index');
    }

    public function show(Specialization $specialization)
    {
        abort_if(Gate::denies('specialization_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $specialization->load('specializationUsers', 'specializationEvents', 'specializationCourses', 'specializationWebinars');

        return view('admin.specializations.show', compact('specialization'));
    }

    public function destroy(Specialization $specialization)
    {
        abort_if(Gate::denies('specialization_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $specialization->delete();

        return back();
    }

    public function massDestroy(MassDestroySpecializationRequest $request)
    {
        Specialization::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('specialization_create') && Gate::denies('specialization_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Specialization();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
