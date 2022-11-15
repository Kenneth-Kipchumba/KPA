<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreWebinarRequest;
use App\Http\Requests\UpdateWebinarRequest;
use App\Http\Resources\Admin\WebinarResource;
use App\Models\Webinar;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebinarsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('webinar_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WebinarResource(Webinar::with(['specialization'])->get());
    }

    public function store(StoreWebinarRequest $request)
    {
        $webinar = Webinar::create($request->all());

        if ($request->input('image', false)) {
            $webinar->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        return (new WebinarResource($webinar))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Webinar $webinar)
    {
        abort_if(Gate::denies('webinar_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WebinarResource($webinar->load(['specialization']));
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

        return (new WebinarResource($webinar))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Webinar $webinar)
    {
        abort_if(Gate::denies('webinar_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $webinar->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
