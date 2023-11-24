<?php

namespace App\Models;

use App\AdminListingFilter;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
use Brackets\Media\HasMedia\MediaCollection;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Models\Media as MediaModel;


class DatiContratto extends Model implements HasMedia
{
    use SoftDeletes;
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;

    protected $table = 'dati_contratto';

    //protected $hidden = ["media"];

    //protected $dateFormat = 'YYYY-MM-DD HH:mm:ss';

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('rec')
            ->accepts("audio/mpeg")
            ->maxNumberOfFiles(5)
            ->maxFileSize(10 * 1024 * 1024)
            ->useDisk("media_private")
            ->canView('dati-contratto.upload.can-download')
            ->canUpload(empty($this->id) ? 'dati-contratto.upload.attach-on-create' : 'dati-contratto.upload.attach-on-edit')
        ;

        $this->addMediaCollection('doc')
            ->accepts("application/pdf","image/jpeg","image/jpg")
            ->maxNumberOfFiles(5)
            ->maxFileSize(10 * 1024 * 1024)
            ->useDisk("media_private")
            ->canView('dati-contratto.upload.can-download')
            ->canUpload(empty($this->id) ? 'dati-contratto.upload.attach-on-create' : 'dati-contratto.upload.attach-on-edit')
        ;
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

    public function shouldDeletePreservingMedia(): bool
    {
        return false;
    }


    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];


    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date
            ->setTimezone(config("app.timezone", "Europe/Rome"));
        //->format('Y-m-d H:i:s');
    }


    protected $fillable = [
        'created_at',
        'updated_at',
        'deleted_at',
        'recover_at',

        'campagna',
        'crm_user',
        'update_user',
        'partner',
        'codice_pratica',
        'esito',
        'owner_nome',
        'owner_cognome',
        'owner_cf',
        'luce_pod',
        'gas_pdr',

        'tipo_inserimento',
        'tipo_offerta',
        'tipo_contratto',

        'tipo_fatturazione',
        'tipo_fatturazione_cartaceo',
        'tipo_fatturazione_email',

        'owner_dob',
        'owner_pob',
        'owner_tipo_doc',
        'owner_nr_doc',
        'owner_ente_doc',
        'owner_doc_data',
        'owner_doc_scadenza',
        'owner_piva',
        'owner_rag_soc',
        'owner_email',
        'telefono',
        'cellulare',
        'owner_indirizzo',
        'owner_civico',
        'owner_comune',
        'owner_prov',
        'owner_cap',
        'owner_az_nome_societa',
        'owner_az_codice_business',
        'owner_az_comune',
        'owner_az_prov',
        'owner_az_cap',
        'forn_indirizzo',
        'forn_civico',
        'forn_comune',
        'forn_prov',
        'forn_cap',
        'fatt_indirizzo',
        'fatt_civico',
        'fatt_comune',
        'fatt_prov',
        'fatt_cap',
        'mod_pagamento',
        'sdd_iban',
        'sdd_ente',
        'sdd_intestatario',
        'sdd_cf',
        'delega',
        'delega_nome',
        'delega_cognome',
        'delega_dob',
        'delega_pob',
        'delega_cf',
        'delega_tipo_doc',
        'delega_nr_doc',
        'delega_ente_doc',
        'delega_doc_data',
        'delega_doc_scadenza',
        'delega_tipo_rapporto',
        'titolarita_immobile',

        'luce_polizza',
        'luce_kw',
        'luce_tensione',
        'luce_consumo',
        'luce_fornitore',
        'luce_mercato',

        'gas_polizza',
        'gas_polizza_caldaia',
        'gas_consumo',
        'gas_fornitore',
        'gas_matricola',
        'gas_remi',
        'gas_mercato',

        'tel_offerta',
        'tel_cod_mig_voce',
        'tel_cod_mig_adsl',
        'tel_cellulare_assoc',
        'tel_fornitore',
        'tel_tipo_linea',
        'tel_iccd',
        'tel_scadenza_telecom',
        'tel_tipo_passaggio',
        'tel_passaggio_numero',
        'tel_finanziamento',
        'tel_canone',
        'tel_sell_smartphone',
        'tel_gia_cliente',
        'note_ope',
        'note_bo',
        'note_sv',
        'note_verifica',


        'id_rec',

        'fascia_reperibilita',
        'recall_at',

        'lista'
    ];


    protected $dates = [

    ];

    public $timestamps = true;

    protected $appends = ['resource_url', 'nome_intestatario', 'mese_creazione', 'anno_creazione'];

    /* ************************ ACCESSOR ************************* */

    public function getNomeIntestatarioAttribute()
    {
        if ($this->tipo_contratto == "business") {
            return $this->owner_rag_soc;
        }
        return $this->owner_nome . " " . $this->owner_cognome;
    }

    public function getResourceUrlAttribute()
    {
        return url('/dati-contratto/' . $this->getKey());
    }

    public function getMeseCreazioneAttribute()
    {
        if (empty($this->created_at)) return "";
        $ex = explode("-", $this->created_at);
        if (count($ex) > 2) return $ex[1];
        return "";
    }

    public function getAnnoCreazioneAttribute()
    {
        if (empty($this->created_at)) return "";
        $ex = explode("-", $this->created_at);
        if (count($ex) > 2) return $ex[0];
        return "";
    }

    public function campagna()
    {
        return $this->belongsTo('App\Models\Campagna', 'campagna');
    }

    public function esito()
    {
        return $this->belongsTo('App\Models\Esito', 'esito', 'id');
    }

    public function partner()
    {
        return $this->belongsTo('App\Models\Partner', 'partner');
    }

    public function crm_user()
    {
        return $this->belongsTo('App\Models\CrmUser', 'crm_user');
    }


    public function update_user()
    {
        return $this->belongsTo('App\Models\CrmUser', 'update_user');
    }

    public function scopeVisibleQuery($query, $request)
    {

        $query->when(!$request->isAdminRequest() && !Auth::user()->hasRole("Admin"), function ($query) use ($request) {

            $aP = Auth::user()->hasAssignedPartners();
            $aC = Auth::user()->hasAssignedCampaigns();
            $and = $aP && $aC;


            if ((!$and && $aC) || $and) {
                $query->whereHas('campagna', function ($query) use ($request) {
                    $query->allAssignedCampaigns();
                });
            }

            if ((!$and && $aP) || $and) {
                $query->whereHas('partner', function ($query) use ($request) {
                    $query->allAssignedPartners();
                });
            }


            if (!$aP && !$aC) {
                $query->whereHas('campagna', function ($query) use ($request) {
                    $query->allAssignedCampaigns();
                });
                $query->whereHas('partner', function ($query) use ($request) {
                    $query->allAssignedPartners();
                });
            }

        });

        $query->when(Auth::user()->hasRole("Admin"), function ($query) {

            $query->whereHas("partner", function ($query) {
                $query->withoutTrashed();
            });

            $query->whereHas("campagna", function ($query) {
                $query->withoutTrashed();
            });

        });

        $query->whereHas("esito", function ($query) {
            $query->withoutTrashed();
        });

        $query->whereHas("crm_user", function ($query) {
            $query->withoutTrashed();
        });

        $query->with(["esito", "campagna", 'partner', "crm_user"]);

        return $query;
    }

    public function scopeCreateDateFilterQuery($query, $request)
    {

        if (!empty($request->input("fromDate"))) {
            $query->where("created_at", ">=", $request->input("fromDate") . " 00:00:00");
        }
        if (!empty($request->input("toDate"))) {
            $query->where("created_at", "<=", $request->input("toDate") . " 23:59:59");
        }

        return $query;
    }

    public function scopeRecallDateFilterQuery($query, $request)
    {
        if (!empty($request->input("recall_fromDate"))) {
            $query->where("recall_at", ">=", $request->input("recall_fromDate"));
        }
        if (!empty($request->input("recall_toDate"))) {
            $query->where("recall_at", "<=", $request->input("recall_toDate"));
        }

        return $query;
    }

    public function scopeRecallMinutes($query, $minutes)
    {
        $dtFormat = "Y-m-d H:i:s";
        $now = (new \DateTime())->format($dtFormat);
        $endTime = (new \DateTime())->modify("+{$minutes} minutes")->format($dtFormat);

        $query->whereBetween('recall_at', [$now, $endTime]);
        return $query;
    }

    public function scopeRecallToday($query)
    {

        $today = (new \DateTime())->format("Y-m-d");
        $todayStart = $today . " 00:00:00";
        $todayEnd = $today . " 23:59:59";

        $query->whereBetween('recall_at', [$todayStart, $todayEnd]);
        return $query;
    }

    public function scopeRecallExpiredToday($query)
    {
        $dtFormat = "Y-m-d H:i:s";
        $today = (new \DateTime())->format("Y-m-d");
        $todayStart = $today . " 00:00:00";
        $nowPrev = (new \DateTime())->modify('-1 minutes')->format($dtFormat);
        $query->whereBetween('recall_at', [$todayStart, $nowPrev]);

        return $query;
    }

    public function scopeRecallAllExpired($query)
    {
        $dtFormat = "Y-m-d H:i:s";
        $nowPrev = (new \DateTime())->modify('-1 minutes')->format($dtFormat);
        $query->where('recall_at', '<=', $nowPrev);
        return $query;
    }


    public function scopePartnersInsert($query,$request){
        $query
            ->select(DB::raw('count(*) as tot, partner'))
            ->createDateFilterQuery($request)
            ->whereHas("partner", function ($query) {
                $query->withoutTrashed();
            })
            ->groupBy("partner")->with(["partner"]);
        return $query;
    }


    public function scopeCampaignsInsert($query,$request){
        $query->select(DB::raw('count(*) as tot, campagna'))->groupBy("campagna")->with(["campagna"]);
        $query->createDateFilterQuery($query,$request);
        return $query;
    }


    public static function getRecallCounters($request, $selectColumn, $searchColumn, $dropdownColumns)
    {

        $request->merge([
            'bulk'
        ]);

        //$except = ['recall_fromDate', 'recall_toDate'];
        //$cleanup = $request->except($except);
        //$request->query = new \Symfony\Component\HttpFoundation\ParameterBag($cleanup);

        $tot_min15 = AdminListingFilter::create(DatiContratto::class)->processRequestAndGet(
            $request,
            $selectColumn,
            $searchColumn,
            function ($query) use ($request) {
                $query->visibleQuery($request);
                $query->createDateFilterQuery($request);
                $query->recallMinutes(15);
            },
            null,
            $dropdownColumns,
            true
        )->count();

        $tot_min30 = AdminListingFilter::create(DatiContratto::class)->processRequestAndGet(
            $request,
            $selectColumn,
            $searchColumn,
            function ($query) use ($request) {
                $query->visibleQuery($request);
                $query->createDateFilterQuery($request);
                $query->recallMinutes(30);
            },
            null,
            $dropdownColumns,
            true
        )->count();


        $tot_min60 = AdminListingFilter::create(DatiContratto::class)->processRequestAndGet(
            $request,
            $selectColumn,
            $searchColumn,
            function ($query) use ($request) {
                $query->visibleQuery($request);
                $query->createDateFilterQuery($request);
                $query->recallMinutes(60);
            },

            null,

            $dropdownColumns,
            true
        )->count();


        $tot_today = AdminListingFilter::create(DatiContratto::class)->processRequestAndGet(
            $request,
            $selectColumn,
            $searchColumn,
            function ($query) use ($request) {
                $query->visibleQuery($request);
                $query->createDateFilterQuery($request);
                $query->recallToday();
            },
            null,
            $dropdownColumns,
            true
        )->count();


        $expired_today = AdminListingFilter::create(DatiContratto::class)->processRequestAndGet(
            $request,
            $selectColumn,
            $searchColumn,
            function ($query) use ($request) {
                $query->visibleQuery($request);
                $query->createDateFilterQuery($request);
                $query->recallExpiredToday();
            },
            null,
            $dropdownColumns,
            true
        )->count();

        $all_expired = AdminListingFilter::create(DatiContratto::class)->processRequestAndGet(
            $request,
            $selectColumn,
            $searchColumn,
            function ($query) use ($request) {
                $query->visibleQuery($request);
                $query->createDateFilterQuery($request);
                $query->recallAllExpired();
            },
            null,
            $dropdownColumns,
            true
        )->count();

        return array_merge([
            "partial_min15" => $tot_min15,
            "partial_min30" => $tot_min30,
            "partial_min60" => $tot_min60,
            "partial_today" => $tot_today,
            "partial_expired_today" => $expired_today,
            "partial_all_expired" => $all_expired
        ], self::getTotalRecallCounters($request));

    }


    public static function getTotalRecallCounters($request)
    {
        $dtFormat = "Y-m-d H:i:s";
        $now = (new \DateTime())->format($dtFormat);
        $min15 = (new \DateTime())->modify('+15 minutes')->format($dtFormat);
        $min30 = (new \DateTime())->modify('+30 minutes')->format($dtFormat);
        $min60 = (new \DateTime())->modify('+60 minutes')->format($dtFormat);

        $today = (new \DateTime())->format("Y-m-d");
        $todayStart = $today . " 00:00:00";
        $todayEnd = $today . " 23:59:59";
        $nowPrev = (new \DateTime())->modify('-1 minutes')->format($dtFormat);

        $tot_min15 = DatiContratto::visibleQuery($request)->whereBetween('recall_at', [$now, $min15])->count();
        $tot_min30 = DatiContratto::visibleQuery($request)->whereBetween('recall_at', [$now, $min30])->count();
        $tot_min60 = DatiContratto::visibleQuery($request)->whereBetween('recall_at', [$now, $min60])->count();
        $tot_today = DatiContratto::visibleQuery($request)->whereBetween('recall_at', [$todayStart, $todayEnd])->count();
        $expiredToday = DatiContratto::visibleQuery($request)->whereBetween('recall_at', [$todayStart, $nowPrev])->count();
        $allExpired = DatiContratto::visibleQuery($request)->where('recall_at', '<=', $nowPrev)->count();

        return [
            "tot_min15" => $tot_min15,
            "tot_min30" => $tot_min30,
            "tot_min60" => $tot_min60,
            "tot_today" => $tot_today,
            "tot_expired_today" => $expiredToday,
            "tot_all_expired" => $allExpired
        ];
    }


    public static function scopeGetLockedTs($query,$request){

        $query->selectRaw("date(recall_at) as day, hour(recall_at) as hour, count(*) as tot")
            ->whereNotNull("recall_at")
            ->whereRaw("date(recall_at) >= '{$request->input("fromDate")}'")
            ->whereRaw("date(recall_at) <= '{$request->input("toDate")}'")
            ->when($request->has("id"),function($query) use ($request){
                $query->where("id","<>",$request->input("id"));
            })
            ->groupByRaw("date(recall_at), hour(recall_at)");

            if(env("MAX_RECALL_PER_HOUR",0)>0){
                $query->havingRaw("tot>=".env("MAX_RECALL_PER_HOUR",3));
            }
            else{
                $query->havingRaw("tot<0");
            }

        return $query;
    }

}
