<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEventsReportRequest;
use App\Http\Requests\StoreEventsReportRequest;
use App\Http\Requests\UpdateEventsReportRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventsReportController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('events_report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.eventsReports.index');
    }

    public function create()
    {
        abort_if(Gate::denies('events_report_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.eventsReports.create');
    }

    public function store(StoreEventsReportRequest $request)
    {
        $eventsReport = EventsReport::create($request->all());

        return redirect()->route('admin.events-reports.index');
    }

    public function edit(EventsReport $eventsReport)
    {
        abort_if(Gate::denies('events_report_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.eventsReports.edit', compact('eventsReport'));
    }

    public function update(UpdateEventsReportRequest $request, EventsReport $eventsReport)
    {
        $eventsReport->update($request->all());

        return redirect()->route('admin.events-reports.index');
    }

    public function show(EventsReport $eventsReport)
    {
        abort_if(Gate::denies('events_report_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.eventsReports.show', compact('eventsReport'));
    }

    public function destroy(EventsReport $eventsReport)
    {
        abort_if(Gate::denies('events_report_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventsReport->delete();

        return back();
    }

    public function massDestroy(MassDestroyEventsReportRequest $request)
    {
        EventsReport::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
