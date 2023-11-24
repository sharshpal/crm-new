<?php

namespace app\Http\Controllers\Upload;

use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Brackets\Media\Http\Controllers\FileViewController;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response as ResponseFacade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\MediaCollections\Models\Media as MediaModel;

class MyFileViewController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param Request $request
     * @return Response|null
     * @throws FileNotFoundException
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function view(Request $request, int $id, string $name): ?Response
    {

        if ($medium = app(MediaModel::class)->find($id)) {

            if ($medium->file_name == $name) {

                /** @var HasMediaCollectionsTrait $model */
                $model = $medium->model; // PHPStorm sees it as an error - Spatie should fix this using PHPDoc

                if ($mediaCollection = $model->getMediaCollection($medium->collection_name)) {
                    if ($mediaCollection->getViewPermission()) {
                        $this->authorize($mediaCollection->getViewPermission(), [$model]);
                    }

                    $fileSystem = Storage::disk($mediaCollection->getDisk());
                    $partialPath = $id."/".$name;

                    if (!$fileSystem->exists($partialPath)) {
                        abort(404);
                    }

                    return ResponseFacade::make($fileSystem->get($partialPath), 200, [
                        'Content-Type' => $fileSystem->mimeType($partialPath),
                        'Content-Disposition' => 'inline; filename="' . basename($request->get('path')) . '"'
                    ]);
                }
            }
        }

        abort(404);
    }
}
