<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreEmailRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Resources\Admin\EmailResource;
use App\Models\Email;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('email_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmailResource(Email::all());
    }

    public function store(StoreEmailRequest $request)
    {
        $email = Email::create($request->all());

        if ($request->input('image', false)) {
            $email->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($request->input('attachments', false)) {
            $email->addMedia(storage_path('tmp/uploads/' . basename($request->input('attachments'))))->toMediaCollection('attachments');
        }

        return (new EmailResource($email))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Email $email)
    {
        abort_if(Gate::denies('email_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmailResource($email);
    }

    public function update(UpdateEmailRequest $request, Email $email)
    {
        $email->update($request->all());

        if ($request->input('image', false)) {
            if (!$email->image || $request->input('image') !== $email->image->file_name) {
                if ($email->image) {
                    $email->image->delete();
                }
                $email->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($email->image) {
            $email->image->delete();
        }

        if ($request->input('attachments', false)) {
            if (!$email->attachments || $request->input('attachments') !== $email->attachments->file_name) {
                if ($email->attachments) {
                    $email->attachments->delete();
                }
                $email->addMedia(storage_path('tmp/uploads/' . basename($request->input('attachments'))))->toMediaCollection('attachments');
            }
        } elseif ($email->attachments) {
            $email->attachments->delete();
        }

        return (new EmailResource($email))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Email $email)
    {
        abort_if(Gate::denies('email_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $email->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
