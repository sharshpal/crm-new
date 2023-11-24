<?php

namespace app\Http\Controllers\Upload;

use Brackets\Media\HasMedia\MediaCollection;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Brackets\Media\Http\Controllers\FileUploadController;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MyFileUploadController extends FileUploadController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param Request $request
     * @throws AuthorizationException
     * @return JsonResponse
     */
    public function upload(Request $request): JsonResponse
    {

        if($request->route()->named("dtc-attach-file")){
            $this->authorize('dati-contratto.upload.attach-on-create');
        }
        else if($request->route()->named("dte-attach-file")){
            $this->authorize('dati-contratto.upload.attach-on-edit');
        }
        else if($request->route()->named("attach-file")){
            $this->authorize('admin.upload');
        }
        else{
            $this->authorize('admin.upload');
        }

        if ($request->hasFile('file')) {
            $disk = "temp_uploads";
            if($request->has("collection")){
                $disk = "";
            }
            $path = $request->file('file')->store('', ['disk' => 'temp_uploads']);

            return response()->json(['path' => $path], 200);
        }

        return response()->json(trans('brackets/media::media.file.not_provided'), 422);
    }
}
