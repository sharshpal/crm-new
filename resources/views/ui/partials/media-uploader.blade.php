<div class="card-header pl-0">
    @if($mediaCollection->isImage())
        <i class="fa fa-file-image-o"></i>
    @else
        <i class="fa fa-file-o"></i>
    @endif

    @if(isset($label))
        {{ $label }}
    @endif

    @if($mediaCollection->getMaxNumberOfFiles())
        <small>{{ trans('admin.media_uploader.max_number_of_files', ['maxNumberOfFiles' => $mediaCollection->getMaxNumberOfFiles()]) }}</small>
    @endif
    @if($mediaCollection->getMaxFileSize())
        <small>{{ trans('admin.media_uploader.max_size_pre_file', ['maxFileSize' => number_format($mediaCollection->getMaxFileSize()/1024/1024, 2)]) }}</small>
    @endif

    @if($mediaCollection->isPrivate())
        <a class="pull-right" data-toggle="tooltip" data-placement="top" title="{{ trans('admin.media_uploader.private_title') }}"> <i class="fa fa-lock" aria-hidden="true"></i></a>
    @endif
</div>

<media-upload

    ref="{{ $mediaCollection->getName() }}_uploader"
    :collection="'{{ $mediaCollection->getName() }}'"
    :url="'{{ route(!empty($route) ? $route : 'attach-file') }}'"

    @if($mediaCollection->getMaxNumberOfFiles())
        :max-number-of-files="{{ $clickable ? $mediaCollection->getMaxNumberOfFiles() : 0}}"
    @endif

    @if($mediaCollection->getMaxFileSize())
        :max-file-size-in-mb="{{ round(($mediaCollection->getMaxFileSize()/1024/1024), 2) }}"
    @endif

    @if($mediaCollection->getAcceptedFileTypes())
        :accepted-file-types="'{{ implode(',', $clickable ? $mediaCollection->getAcceptedFileTypes() : []) }}'"
    @endif

    @if(isset($media) && $media->count() > 0)
        :uploaded-images="{{ $media->toJson() }}"
    @endif

    @if(isset($clickable))
        :clickable="{{$clickable ? 'true' : 'false'}}"
    @endif

    @if(isset($showRemoveLink))
        :show-remove-link="{{$showRemoveLink ? 'true' : 'false'}}"
    @endif

    @if(isset($disablePreviews))
        :disable-previews="{{$disablePreviews ? 'true' : 'false'}}"
    @endif


></media-upload>
