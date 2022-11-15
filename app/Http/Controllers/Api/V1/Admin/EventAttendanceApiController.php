<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreEventAttendanceRequest;
use App\Http\Requests\UpdateEventAttendanceRequest;
use App\Http\Resources\Admin\EventAttendanceResource;
use App\Models\EventAttendance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventAttendanceApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('event_attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventAttendanceResource(EventAttendance::with(['event', 'member'])->get());
    }

    public function store(StoreEventAttendanceRequest $request)
    {
        $eventAttendance = EventAttendance::create($request->all());

        return (new EventAttendanceResource($eventAttendance))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EventAttendance $eventAttendance)
    {
        abort_if(Gate::denies('event_attendance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventAttendanceResource($eventAttendance->load(['event', 'member']));
    }

    public function update(UpdateEventAttendanceRequest $request, EventAttendance $eventAttendance)
    {
        $eventAttendance->update($request->all());

        return (new EventAttendanceResource($eventAttendance))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EventAttendance $eventAttendance)
    {
        abort_if(Gate::denies('event_attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventAttendance->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
