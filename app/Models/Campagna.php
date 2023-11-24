<?php

namespace App\Models;

use Brackets\AdminAuth\Activation\Contracts\CanActivate as CanActivateContract;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
use Brackets\Media\HasMedia\MediaCollection;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\MediaCollections\Models\Media as MediaModel;

class Campagna extends Model implements HasMedia
{
    protected $table = 'campagna';

    use SoftDeletes;
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;

    protected $fillable = [
        'nome',
        'tipo',
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    protected $dates = [

    ];

    public $timestamps = true;

    protected $appends = ['resource_url','logo_thumb_url'];

    protected $hidden = ['media'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/campaign/' . $this->getKey());
    }

    public function getLogoThumbUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('logo', 'thumb_150') ?: null;
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\CrmUser', 'crm_user_has_campagna', 'campagna', 'crm_user');
    }

    public function partners()
    {
        return $this->belongsToMany('App\Models\Partner', 'partner_has_campagna', 'campagna', 'partner');
    }


    /* ************************ MEDIA ************************ */

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->accepts('image/*')
            //->useDisk("media_private")
        ;
    }

    /**
     * Register media conversions
     *
     * @param Media|null $media
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->autoRegisterThumb200();

        $this->addMediaConversion('thumb_75')
            ->width(75)
            ->height(75)
            ->fit('crop', 75, 75)
            ->optimize()
            ->performOnCollections('logo')
            ->nonQueued();

        $this->addMediaConversion('thumb_150')
            ->width(150)
            ->height(150)
            ->fit('crop', 150, 150)
            ->optimize()
            ->performOnCollections('logo')
            ->nonQueued();
    }

    /**
     * Auto register thumb overridden
     */
    public function autoRegisterThumb200()
    {
        $this->getMediaCollections()->filter->isImage()->each(function ($mediaCollection) {
            $this->addMediaConversion('thumb_200')
                ->width(200)
                ->height(200)
                ->fit('crop', 200, 200)
                ->optimize()
                ->performOnCollections($mediaCollection->getName())
                ->nonQueued();
        });
    }


    /**
     * Process single file metadata add/edit/delete to media library
     *
     * @param $inputMedium
     * @param $mediaCollection
     * @throws FileCannotBeAdded
     */
    public function processMedium(array $inputMedium, MediaCollection $mediaCollection): void
    {
        if (isset($inputMedium['id']) && $inputMedium['id']) {
            if ($medium = app(MediaModel::class)->find($inputMedium['id'])) {
                if (isset($inputMedium['action']) && $inputMedium['action'] === 'delete') {
                    $medium->delete();
                } else {
                    $medium->custom_properties = $inputMedium['meta_data'];
                    $medium->save();
                }
            }
        } elseif (isset($inputMedium['action']) && $inputMedium['action'] === 'add') {

            $oldPath = Storage::disk("temp_uploads")->getDriver()->getAdapter()->applyPathPrefix($inputMedium['path']);
            $newPath = Storage::disk('media_private')->getDriver()->getAdapter()->applyPathPrefix($inputMedium['path']);

            if (Storage::disk("temp_uploads")->exists($inputMedium['path'])) {
                rename($oldPath, $newPath);
            }

            $this->addMedia($newPath)
                ->withCustomProperties($inputMedium['meta_data'])
                ->toMediaCollection($mediaCollection->getName(), $mediaCollection->getDisk());

        }
    }

    /**
     * Validae input data for media
     *
     * @param Collection $inputMediaForMediaCollection
     * @param MediaCollection $mediaCollection
     * @throws FileCannotBeAdded
     */
    public function validate(Collection $inputMediaForMediaCollection, MediaCollection $mediaCollection): void
    {
        $this->validateCollectionMediaCount($inputMediaForMediaCollection, $mediaCollection);
        $inputMediaForMediaCollection->each(function ($inputMedium) use ($mediaCollection) {
            if ($inputMedium['action'] === 'add') {
                $mediumFileFullPath = Storage::disk('temp_uploads')->getDriver()->getAdapter()->applyPathPrefix($inputMedium['path']);
                $this->validateTypeOfFile($mediumFileFullPath, $mediaCollection);
                $this->validateSize($mediumFileFullPath, $mediaCollection);
            }
        });
    }

    /*** SCOPES ***/

    public function scopeAllAssignedCampaigns($query) {

        $query->whereHas("users", function ($query) {
            $query->where("crm_user_has_campagna.crm_user", Auth::user()->id);
        });

        $query->without("media");

        return $query;
    }

    public function scopeAllPartnerCampaigns($query){

        $query->where(function ($query) {
            $query->whereHas("partners", function ($query) {
                $query->whereHas("users", function ($query) {
                    $query->where("crm_user_has_partner.crm_user", Auth::user()->id);
                });
            });
        });

        return $query;
    }

    public function scopeAllUserCampaigns($query){

        $aC = Auth::user()->hasAssignedCampaigns();
        $aP = Auth::user()->hasAssignedPartners();
        $and = $aC && $aP;

        if ($and || (!$and && $aC)) {
            $query
                ->allAssignedCampaigns()
                ->when($aP, function ($query) {
                    //TODO: PROBABILMENTE QUESTA VA IN OR
                    $query->whereHas("partners", function ($query) {
                        $query->whereHas("users", function ($query) {
                            $query->where("crm_user_has_partner.crm_user", Auth::user()->id);
                        });
                    });
                });
        } else if (!$and && $aP) {
            $query->allPartnerCampaigns();
        }
        else{
            $query->whereIn("id",['']);
        }

        return $query;
    }

}
