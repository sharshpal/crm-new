<?php


namespace App\Models;


use App\Helpers\DateTimeHelper;
use Brackets\AdminAuth\Models\AdminUser;
use App\Notifications\ActivationNotification;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\Reminder;
use Illuminate\Support\Facades\Auth;

class UserPerformance extends AdminUser
{

    protected $table = "crm_user";

    protected $appends = ['full_name', 'resource_url',  'ore_rounded', 'partner','avatar_thumb_url'];

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'ore',
        'pezzi_singoli',
        'pezzi_dual',
        'pezzi_energia',
        'pezzi_fisso',
        'pezzi_mobile',
        'pezzi_telefonia',
        'pezzi_tot',
        'resa',
        'pezzi_singoli_lordo',
        'pezzi_dual_lordo',
        'pezzi_energia_lordo',
        'pezzi_fisso_lordo',
        'pezzi_mobile_lordo',
        'pezzi_telefonia_lordo',
        'pezzi_tot_lordo',
        'resa_lordo',
        'cname',
        'pname',
        'pid',
        'cid'
    ];

    protected $hidden = ["media"];

    public function getResourceUrlAttribute()
    {
        return url('/admin/users/' . $this->getKey());
    }

    /**
     * Get url of avatar image
     *
     * @return string|null
     */
    public function getAvatarThumbUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('avatar', 'thumb_150') ?: null;
    }

    public function getPartnerAttribute()
    {
        return $this->partners()->first()->makeHidden(['media','logo_thumb_url']);
    }

    public function getOreRoundedAttribute(){
        return round($this->ore,2);
    }

    public function getResaAttribute(){
        return $this->ore<=0 ? 0 :  round($this->pezzi_tot/$this->ore,2);
    }

    public function getResaLordoAttribute(){
        return $this->ore<=0 ? 0 :  round($this->pezzi_tot_lordo/$this->ore,2);
    }

    public function campaigns()
    {
        return $this->belongsToMany('App\Models\Campagna', 'crm_user_has_campagna', 'crm_user', 'campagna');
    }


    public function partners()
    {
        return $this->belongsToMany('App\Models\Partner', 'crm_user_has_partner', 'crm_user', 'partner');
    }


    public function scopeSamePartnerOfCurrentUser($query)
    {
        $query->whereHas("partners", function ($query) {
            $query->whereIn("crm_user_has_partner.partner", Partner::allAssignedPartners()->get()->pluck("id")->toArray());
        });

        return $query;
    }

    public function scopeSameCampaignsOfCurrentUser($query)
    {
        $query->whereHas("campaigns", function ($query) {
            $query->whereIn("crm_user_has_campagna.campagna", Campagna::allUserCampaigns()->get()->pluck("id")->toArray());
        });

        return $query;
    }



    public function scopeUsersPerformanceStatistics($query, $request)
    {

        $userCampaigns = Campagna::allUserCampaigns()->get()->pluck("id")->toArray();
        $userPartners = Partner::allAssignedPartners()->get()->pluck("id")->toArray();
        $userCampaignsStr = implode(",",$userCampaigns);
        $userPartnersStr = implode(",",$userPartners);
        $isAdmin = Auth::user()->hasRole("Admin");
        $esitiList = Esito::isFinalPositive()->get()->pluck("id")->toArray();
        $esitiListStr = implode(",",$esitiList);

        $esitiLordo = env("USER_PERFORMANCE_INCLUDE_KO",true) ? [] : Esito::isFinalNegative()->get()->pluck("id")->toArray();
        $esitiLordoStr = count($esitiLordo) == 0 ? "''" : implode(",",$esitiLordo);

        $queryOre = "select (sum(ore)+(sum(minuti)/60)) from user_timelog ut where ut.user=crm_user.id";
        $queryTotSingoli = "select count(*) from dati_contratto dt where dt.crm_user=crm_user.id and (dt.tipo_offerta='luce' || dt.tipo_offerta='gas') and dt.esito IN ($esitiListStr)";
        $queryTotDual = "select count(*) from dati_contratto dt where dt.crm_user=crm_user.id and dt.tipo_offerta='lucegas' and dt.esito IN ($esitiListStr)";
        $queryTotFisso = "select count(*) from dati_contratto dt where dt.crm_user=crm_user.id and dt.tipo_offerta='telefonia' and dt.tel_tipo_linea='fisso' and dt.esito IN ($esitiListStr)";
        $queryTotMobile = "select count(*) from dati_contratto dt where dt.crm_user=crm_user.id and dt.tipo_offerta='telefonia' and dt.tel_tipo_linea='mobile' and dt.esito IN ($esitiListStr)";

        $queryTotSingoliLordo = "select count(*) from dati_contratto dt where dt.crm_user=crm_user.id and (dt.tipo_offerta='luce' || dt.tipo_offerta='gas') and dt.esito NOT IN ($esitiLordoStr)";
        $queryTotDualLordo = "select count(*) from dati_contratto dt where dt.crm_user=crm_user.id and dt.tipo_offerta='lucegas' and dt.esito NOT IN ($esitiLordoStr)";
        $queryTotFissoLordo = "select count(*) from dati_contratto dt where dt.crm_user=crm_user.id and dt.tipo_offerta='telefonia' and dt.tel_tipo_linea='fisso' and dt.esito NOT IN ($esitiLordoStr)";
        $queryTotMobileLordo = "select count(*) from dati_contratto dt where dt.crm_user=crm_user.id and dt.tipo_offerta='telefonia' and dt.tel_tipo_linea='mobile' and dt.esito NOT IN ($esitiLordoStr)";

        $queryArray = [
            "tot_singoli" => $queryTotSingoli,
            "tot_dual" => $queryTotDual,
            "tot_fisso" => $queryTotFisso,
            "tot_mobile" => $queryTotMobile,
            "tot_singoli_l" => $queryTotSingoliLordo,
            "tot_dual_l" => $queryTotDualLordo,
            "tot_fisso_l" => $queryTotFissoLordo,
            "tot_mobile_l" => $queryTotMobileLordo
        ];


        if ($request->has("fromDate") && !empty($request->input("fromDate"))) {

            foreach($queryArray as $index =>  $q){
                $queryArray[$index] .= " AND dt.created_at>='" . $request->input("fromDate")." 00:00:00'";
            }
            $queryOre .= " AND ut.period>='" . $request->input("fromDate")."'";
        }

        if ($request->has("toDate") && !empty($request->input("toDate"))) {
            foreach($queryArray as $index =>  $q){
                $queryArray[$index] .= " AND dt.created_at<='" . $request->input("toDate")." 23:59:59'";
            }
            $queryOre .= " AND ut.period<='" . $request->input("toDate")."'";
        }

        if(!$isAdmin){
            if(count($userCampaigns)>0){
                foreach($queryArray as $index =>  $q){
                    $queryArray[$index] .= " AND dt.campagna IN ({$userCampaignsStr})";
                }
            }
            if(count($userPartners)>0){
                foreach($queryArray as $index =>  $q){
                    $queryArray[$index] .= " AND dt.partner IN ({$userPartnersStr})";
                }
            }
        }

        $query->select("crm_user.id", "crm_user.email", "crm_user.first_name", "crm_user.last_name");

        $query_fields = [
            "ore" => "($queryOre)",

            "pezzi_singoli" => "({$queryArray['tot_singoli']})",
            "pezzi_dual" => "({$queryArray['tot_dual']})",
            "pezzi_energia" => "( pezzi_singoli + (pezzi_dual*2) )",
            "pezzi_fisso" => "({$queryArray['tot_fisso']})",
            "pezzi_mobile" => "({$queryArray['tot_mobile']})",
            "pezzi_telefonia" => "( pezzi_fisso + (pezzi_mobile*0.33) )",
            "pezzi_tot" => "( pezzi_energia + pezzi_telefonia )",
            "resa"=>"( pezzi_tot/ore )",

            "pezzi_singoli_lordo" => "({$queryArray['tot_singoli_l']})",
            "pezzi_dual_lordo" => "({$queryArray['tot_dual_l']})",
            "pezzi_energia_lordo" => "( pezzi_singoli_lordo + (pezzi_dual_lordo*2) )",
            "pezzi_fisso_lordo" => "({$queryArray['tot_fisso_l']})",
            "pezzi_mobile_lordo" => "({$queryArray['tot_mobile_l']})",
            "pezzi_telefonia_lordo" => "( pezzi_fisso_lordo + (pezzi_mobile_lordo*0.33) )",
            "pezzi_tot_lordo" => "( pezzi_energia_lordo + pezzi_telefonia_lordo )",
            "resa_lordo"=>"( pezzi_tot_lordo/ore )",
        ];

        foreach($query_fields as $field => $expr){
            $query->selectSub(function ($query) use ($expr) {
                return $query->selectRaw($expr);
            }, $field);
        }

        /*
        $query->selectSub(function ($query) use ($queryOre) {
            return $query->selectRaw("($queryOre)");
        }, 'ore');

        $query->selectSub(function ($query) use ($queryTotSingoli) {
            return $query->selectRaw("($queryTotSingoli)");
        }, 'pezzi_singoli');

        $query->selectSub(function ($query) use ($queryTotDual) {
            return $query->selectRaw("($queryTotDual)");
        }, 'pezzi_dual');

        $query->selectSub(function ($query) use ($queryTotDual) {
            return $query->selectRaw("( pezzi_singoli + (pezzi_dual*2) )");
        }, 'pezzi_energia');

        $query->selectSub(function ($query) use ($queryTotFisso) {
            return $query->selectRaw("($queryTotFisso)");
        }, 'pezzi_fisso');

        $query->selectSub(function ($query) use ($queryTotMobile) {
            return $query->selectRaw("($queryTotMobile)");
        }, 'pezzi_mobile');

        $query->selectSub(function ($query) use ($queryTotDual) {
            return $query->selectRaw("( pezzi_fisso + (pezzi_mobile*0.33) )");
        }, 'pezzi_telefonia');

        $query->selectSub(function ($query) use ($queryTotDual) {
            return $query->selectRaw("( pezzi_energia + pezzi_telefonia )");
        }, 'pezzi_tot');

        $query->selectSub(function ($query) use ($queryTotDual) {
            return $query->selectRaw("( pezzi_tot/ore )");
        }, 'resa');
        */

        //$query->withTrashed();

        if($request->has("search")){
            $query->where(function($query) use ($request){
                $query->where("crm_user.first_name", "LIKE", '%' . $request->input("search"). '%');
                $query->orWhere(function($query) use ($request){
                    $query->where("crm_user.last_name", "LIKE" , '%' . $request->input("search"). '%');
                    $query->orWhere("crm_user.email", "LIKE" , '%' . $request->input("search"). '%');
                });
            });
        }


        /*
        $query->when(!$isAdmin, function ($query) {
            $query->samePartnerOfCurrentUser();
            $query->sameCampaignsOfCurrentUser();
        });
        */


        $query->join('crm_user_has_partner', function ($join) use($isAdmin,$userPartners) {
            $join->on('crm_user_has_partner.crm_user', '=', 'crm_user.id');
            $join->when(!$isAdmin && count($userPartners)>0,function($join) use ($userPartners){
                $join->whereIn('crm_user_has_partner.partner',$userPartners);
            });
        });


        $query->when($request->has("partner"),function($query)use($request){
            /*
            $query->join('partner', function ($join) {
                $join->on('crm_user_has_partner.partner', '=', 'partner.id');
            });
            */
            $query->whereIn("crm_user_has_partner.partner",$request->input("partner"));
        });

        //$query->with(["partners","campaigns"]);
        //$query->load("partners");
        //$query->load("campaign");

        $query->join('crm_user_has_campagna', function ($join) use($isAdmin,$userCampaigns) {
            $join->on('crm_user_has_campagna.crm_user', '=', 'crm_user.id');
            $join->when(!$isAdmin && count($userCampaigns)>0,function($join) use ($userCampaigns) {
                $join->whereIn('crm_user_has_campagna.campagna',$userCampaigns);
            });
        });

        /*
        $query->join('campagna', function ($join) {
            $join->on('crm_user_has_campagna.campagna', '=', 'campagna.id');
        });
        */

        $query->groupBy("crm_user.id");

        $query->havingRaw('pezzi_tot>0 OR pezzi_tot_lordo>0 OR ore>0');

        if($request->has("orderBy") && $request->has("orderDirection")){
            $orderSql = " {$request->input('orderBy')} {$request->input('orderDirection')}";
            $query->orderByRaw($orderSql);
        }

        return $query;
    }


}
