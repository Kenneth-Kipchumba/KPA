<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEventAttendanceRequest;
use App\Http\Requests\StoreEventAttendanceRequest;
use App\Http\Requests\UpdateEventAttendanceRequest;
use App\Models\Event;
use App\Models\EventAttendance;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EventAttendanceController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('event_attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EventAttendance::with(['event', 'member'])->select(sprintf('%s.*', (new EventAttendance())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'event_attendance_show';
                $editGate = 'event_attendance_edit';
                $deleteGate = 'event_attendance_delete';
                $crudRoutePart = 'event-attendances';

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
            $table->addColumn('event_name', function ($row) {
                return $row->event ? $row->event->name : '';
            });

            $table->editColumn('event.category', function ($row) {
                return $row->event ? (is_string($row->event) ? $row->event : $row->event->category) : '';
            });
            $table->addColumn('member_name', function ($row) {
                return $row->member ? $row->member->name : '';
            });

            $table->editColumn('dates', function ($row) {
                return $row->dates ? $row->dates : '';
            });
            $table->editColumn('receipt_no', function ($row) {
                return $row->receipt_no ? $row->receipt_no : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'event', 'member']);

            return $table->make(true);
        }

        return view('admin.eventAttendances.index');
    }

    public function create()
    {
        abort_if(Gate::denies('event_attendance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $events = Event::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $members = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.eventAttendances.create', compact('events', 'members'));
    }

    public function store(StoreEventAttendanceRequest $request)
    {
        $eventAttendance = EventAttendance::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $eventAttendance->id]);
        }

        return redirect()->route('admin.event-attendances.index');
    }

    public function edit(EventAttendance $eventAttendance)
    {
        abort_if(Gate::denies('event_attendance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $events = Event::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $members = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $eventAttendance->load('event', 'member');

        return view('admin.eventAttendances.edit', compact('events', 'members', 'eventAttendance'));
    }

    public function update(UpdateEventAttendanceRequest $request, EventAttendance $eventAttendance)
    {
        $eventAttendance->update($request->all());

        return redirect()->route('admin.event-attendances.index');
    }

    public function show(EventAttendance $eventAttendance)
    {
        abort_if(Gate::denies('event_attendance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventAttendance->load('event', 'member');

        return view('admin.eventAttendances.show', compact('eventAttendance'));
    }

    public function destroy(EventAttendance $eventAttendance)
    {
        abort_if(Gate::denies('event_attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventAttendance->delete();

        return back();
    }

    public function massDestroy(MassDestroyEventAttendanceRequest $request)
    {
        EventAttendance::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('event_attendance_create') && Gate::denies('event_attendance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new EventAttendance();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
