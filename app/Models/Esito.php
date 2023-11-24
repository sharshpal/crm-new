<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Esito extends Model
{
    protected $table = 'esito';
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'cod',
        'is_final',
        'is_new',
        'is_ok',
        'is_recover',
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    protected $dates = [

    ];

    public $timestamps = true;

    protected $appends = ['resource_url','is_not_ok'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/esito/' . $this->getKey());
    }

    public function getIsNotOkAttribute(){
        return $this->is_final && !$this->is_ok;
    }


    public static function getEsitiContrattiStats($where,$groupByPartner=false,$groupByCampagna=false, $groupByUser=false, $groupByLabel=false)
    {

        $queryTotal = "SELECT
                count(*) as total,
                sum(CASE WHEN tipo_offerta='lucegas' THEN 2 ELSE 1 END) as totalPz
                FROM dati_contratto dt
                JOIN esito e ON dt.esito=e.id AND e.deleted_at IS NULL
                JOIN crm_user cu ON dt.crm_user=cu.id AND cu.deleted_at IS NULL
                LEFT JOIN crm_user du ON dt.update_user=du.id AND du.deleted_at IS NULL
                JOIN campagna c ON dt.campagna=c.id AND c.deleted_at IS NULL
                JOIN partner p ON dt.partner=p.id AND p.deleted_at IS NULL
                $where
                ";

        $queryTotalRs = DB::selectOne(DB::raw($queryTotal));

        $qt = $queryTotalRs->total;
        $qtPz = $queryTotalRs->totalPz;

        $queryTotalGroup = "SELECT
                count(*) as totalGroup,
                sum(CASE WHEN tipo_offerta='lucegas' THEN 2 ELSE 1 END) as totalGroupPz,
                e.id as id,
                e.nome
                " . ($groupByPartner ? ', p.nome as partner, p.id as pid' : '') . ($groupByCampagna ? ' , c.nome as campagna, c.id as cid' : '') ."
                FROM dati_contratto dt
                JOIN esito e ON dt.esito=e.id AND e.deleted_at IS NULL
                JOIN crm_user cu ON dt.crm_user=cu.id AND cu.deleted_at IS NULL
                LEFT JOIN crm_user du ON dt.update_user=du.id AND du.deleted_at IS NULL
                JOIN campagna c ON dt.campagna=c.id AND c.deleted_at IS NULL
                JOIN partner p ON dt.partner=p.id AND p.deleted_at IS NULL
                $where";

                $grp = $groupByPartner || $groupByCampagna ? " group by " : "";
                if(strlen($grp)){
                    $t = [];
                    if($groupByPartner) $t[] = "p.id";
                    if($groupByCampagna) $t[] = "c.id";
                    if($groupByUser) $t[] = "cu.id";
                    $grp .= implode(",",$t);
                }
            $queryTotalGroup .= " $grp";


        $qtTotalGroup = DB::select(DB::raw($queryTotalGroup));

        $where2 = "esito.deleted_at IS NULL";
        if (strlen($where)) {
            $where2 = "{$where} AND {$where2}";
        }

        $query = "SELECT esito.id, esito.nome, cu.id as cuid, cu.first_name, cu.last_name, cu.email, count(dt.id) as partialCount, sum(CASE WHEN dt.tipo_offerta='lucegas' THEN 2 ELSE 1 END) as partialCountPz, esito.is_final, esito.is_new, esito.is_ok, esito.is_recover "
                 .($groupByPartner ? ', p.nome as partner, p.id as pid' : '') . ($groupByCampagna ? ' , c.nome as campagna, c.id as cid' : '') . "

                    , CASE
                        WHEN NOT esito.is_final AND esito.is_new THEN 'OPEN_NEW'
                        WHEN NOT esito.is_final AND esito.is_ok THEN 'OPEN_OK'
                        WHEN NOT esito.is_final AND NOT esito.is_ok THEN 'OPEN_KO'
                        WHEN esito.is_final AND esito.is_ok THEN 'FINAL_OK'
                        WHEN esito.is_final AND NOT esito.is_ok THEN 'FINAL_KO'
                        WHEN esito.is_recover THEN 'RECOVER'
                        ELSE 'OPEN'
                    END
                    AS label

                    FROM esito
                    JOIN dati_contratto as dt ON dt.esito = esito.id
                    JOIN crm_user cu ON dt.crm_user=cu.id AND cu.deleted_at IS NULL
                    LEFT JOIN crm_user du ON dt.update_user=du.id AND du.deleted_at IS NULL
                    JOIN campagna c ON dt.campagna=c.id AND c.deleted_at IS NULL
                    JOIN partner p ON dt.partner=p.id AND p.deleted_at IS NULL
                    $where2
                    group by label "  .   ($groupByLabel ? " , esito.id " : "")   . ($groupByPartner ? ', p.id' : '') . ($groupByCampagna ? ' , c.id' : '') . ($groupByUser ? ' , cu.id' : '');


        //dd($query);


        $order = "";
        if($groupByPartner){
            $order .= (strlen($order) ? " , " : "");
            $order .= " pid ASC";
        }
        if($groupByCampagna){
            $order .= (strlen($order) ? " , " : "");
            $order .= " cid ASC ";
        }
        if($groupByUser){
            $order .= (strlen($order) ? " , " : "");
            $order .= " cuid ASC ";
        }

        if(strlen($order)){
            $query .= " ORDER BY $order, esito.is_final desc, esito.is_ok desc, esito.is_new asc, partialCount desc, esito.nome asc";
        }
        else{
            $query .= " ORDER BY esito.is_final desc, esito.is_ok desc, esito.is_new asc, partialCount desc, esito.nome asc";
        }

        $esiti = DB::select(DB::raw($query));

        $result = [
            "esiti" => $esiti,
            "total" => $qt,
            "totalPz" => $qtPz,
            "totalGroup"=>$qtTotalGroup,
            "groupByPartner"=>$groupByPartner,
            "groupByCampagna"=>$groupByCampagna,
            "groupByUser"=>$groupByUser,
            "groupByLabel"=>$groupByLabel
        ];

        return $result;
    }

    public function scopeNotNew($query)
    {
        $query->where("is_new", "=", 0);
    }


    public static function getEsitiCounters($request, $searchColumn, $concatColumns, $groupByPartner=false,$groupByCampagna=false,$groupByUser=false,$groupByLabel=false,$filterEsiti=false)
    {

        $aP = Auth::user()->hasAssignedPartners();
        $aC = Auth::user()->hasAssignedCampaigns();

        $where = "";
        if ($request->input("search")) {
            $search = addslashes($request->input("search"));

            foreach ($searchColumn as $col) {
                if (strlen($where) > 0) $where .= " OR ";
                $where .= "(dt.$col LIKE '%$search%')";
            }

            foreach ($concatColumns as $colList) {
                $concatStr = "";
                foreach($colList as $cCol){
                    if(strlen($concatStr)> 0) $concatStr .= ", ' ' , ";
                    $concatStr .= "$cCol";
                }
                $concatStr = "CONCAT({$concatStr})";
                if (strlen($where) > 0) $where .= " OR ";
                $where .= "({$concatStr} LIKE '%$search%')";
            }

        }

        if (strlen($where) > 0) $where = "($where)";

        if ($request->input("campagna")) {

            $campagne = array_values($request->input("campagna"));

            if (!$request->isAdminRequest() && !Auth::user()->hasRole("Admin")) {
                $cList = Campagna::allUserCampaigns()->get()->pluck("id")->toArray();
                $cArr = [];
                foreach ($campagne as $ca) {
                    if (in_array($ca, $cList)) {
                        $cArr[] = $ca;
                    }
                }

                $campagne = $cArr;
            }


            if (strlen($where) > 0) $where .= " AND ";
            $c = count($campagne) ? implode(",", $campagne) : "''";
            $where .= "dt.campagna IN ($c)";

        } else {
            if (!$request->isAdminRequest() && !Auth::user()->hasRole("Admin") && ($aC || (!$aC && !$aP))) {
                if (strlen($where) > 0) $where .= " AND ";
                $campagne = Campagna::allAssignedCampaigns()->get()->pluck("id")->toArray();
                $c = count($campagne) ? implode(",", $campagne) : "''";
                $where .= "dt.campagna IN ($c)";
            }
        }

        if ($request->input("partner")) {

            $partners = array_values($request->input("partner"));

            if (!$request->isAdminRequest() && !Auth::user()->hasRole("Admin")) {
                $cList = Partner::allUserPartner()->get()->pluck("id")->toArray();
                $cArr = [];
                foreach ($partners as $ca) {
                    if (in_array($ca, $cList)) {
                        $cArr[] = $ca;
                    }
                }

                $partners = $cArr;
            }

            if (strlen($where) > 0) $where .= " AND ";
            $p = count($partners) ? implode(",", $partners) : "''";
            $where .= "dt.partner IN ($p)";

        } else {
            if (!$request->isAdminRequest() && !Auth::user()->hasRole("Admin") && ($aP || (!$aC && !$aP))) {
                if (strlen($where) > 0) $where .= " AND ";
                $partners = Partner::allAssignedPartners()->get()->pluck("id")->toArray();
                $p = count($partners) ? implode(",", $partners) : "''";
                $where .= "dt.partner IN ($p)";
            }
        }

        if ($request->input("tipo_contratto")) {

            $tipi = array_values($request->input("tipo_contratto"));
            $intypes = "";
            foreach ($tipi as $t) {
                if (strlen($intypes) > 0) $intypes .= ",";
                $intypes .= "'$t'";
            }

            if (strlen(($intypes)) == 0) return;
            if (strlen(($where)) > 0) $where .= " AND ";

            $where .= "dt.tipo_contratto IN ($intypes)";
        }

        if ($request->input("tipo_inserimento")) {

            $tipi = array_values($request->input("tipo_inserimento"));
            $intypes = "";
            foreach ($tipi as $t) {
                if (strlen($intypes) > 0) $intypes .= ",";
                $intypes .= "'$t'";
            }

            if (strlen(($intypes)) == 0) return;
            if (strlen(($where)) > 0) $where .= " AND ";

            $where .= "dt.tipo_inserimento IN ($intypes)";
        }

        if ($request->input("tipo_offerta")) {

            $tipi = array_values($request->input("tipo_offerta"));
            $intypes = "";
            foreach ($tipi as $t) {
                if (strlen($intypes) > 0) $intypes .= ",";
                $intypes .= "'$t'";
            }

            if (strlen(($intypes)) == 0) return;
            if (strlen(($where)) > 0) $where .= " AND ";

            $where .= "dt.tipo_offerta IN ($intypes)";
        }

        if ($request->input("crm_user")) {

            $users = array_values($request->input("crm_user"));
            $inusers = "";
            foreach ($users as $t) {
                if (strlen($inusers) > 0) $inusers .= ",";
                $inusers .= "'$t'";
            }

            if (strlen(($inusers)) == 0) return;
            if (strlen(($where)) > 0) $where .= " AND ";

            $where .= "dt.crm_user IN ($inusers)";
        }


        if ($request->input("fromDate")) {
            if (strlen(($where)) > 0) $where .= " AND ";
            $date = $request->input("fromDate") . " 00:00:00";
            $where .= "dt.created_at >= '$date'";
        }

        if ($request->input("toDate")) {
            if (strlen(($where)) > 0) $where .= " AND ";
            $date = $request->input("toDate") . " 23:59:59";
            $where .= "dt.created_at <= '$date'";
        }

        if ($request->input("recall_fromDate")) {
            if (strlen(($where)) > 0) $where .= " AND ";
            $date = $request->input("recall_fromDate") . ":00";
            $where .= "dt.recall_at >= '$date'";
        }

        if ($request->input("recall_toDate")) {
            if (strlen(($where)) > 0) $where .= " AND ";
            $date = $request->input("recall_toDate") . ":59";
            $where .= "dt.recall_at <= '$date'";
        }

        if($filterEsiti && $request->input("esito")){

            $esitiInput = array_values($request->input("esito"));

            $cList = Esito::get()->pluck("id")->toArray();
            $cArr = [];
            foreach ($esitiInput as $ca) {
                if (in_array($ca, $cList)) {
                    $cArr[] = $ca;
                }
            }

            $esiti = $cArr;

            if (strlen($where) > 0) $where .= " AND ";
            $e = count($esiti) ? implode(",", $esiti) : "''";
            $where .= "dt.esito IN ($e)";
        }


        $where = strlen($where) > 0 ? " WHERE  (dt.deleted_at IS NULL AND $where) " : " WHERE dt.deleted_at IS NULL";

        $es = self::getEsitiContrattiStats($where, $groupByPartner, $groupByCampagna, $groupByUser, $groupByLabel);

        return $es;
    }

    public function scopeIsFinalPositive($query){
        $query->where("is_final","=","1");
        $query->where("is_ok","=","1");
        return $query;
    }

    public function scopeIsNotFinalNegative($query){

        $query->orWhere(function($query){
            $query->where(function($query){
                $query->where("is_final","=","1");
                $query->where("is_ok","=","1");
            });
            $query->orWhere("is_final","=","0");
        });
        return $query;
    }


    public function scopeIsFinalNegative($query){
        $query->where("is_final","=","1");
        $query->where("is_ok","=","0");
        return $query;
    }

}
