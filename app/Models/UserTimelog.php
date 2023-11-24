<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserTimelog extends Model
{
    protected $table = 'user_timelog';

    protected $fillable = [
        'ore',
        'minuti',
        'user',
        'campagna',
        'period'
    ];


    protected $dates = [
        'period'
    ];

    public $timestamps = false;

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('user-timelog/'.$this->getKey());
    }


    public function user() {
        return $this->belongsTo('App\Models\CrmUser', 'user');
    }

    public function scopeFilterUser($query,$request){

        if($request->has("search")){
            $query->whereHas("user",function($query) use ($request){
                $query->where("crm_user.first_name", "LIKE", '%' . $request->input("search"). '%');
                $query->orWhere(function($query) use ($request){
                    $query->where("crm_user.last_name", "LIKE" , '%' . $request->input("search"). '%');
                    $query->orWhere("crm_user.email", "LIKE" , '%' . $request->input("search"). '%');
                });
            });
        }

        return $query;
    }

    public function scopeFilterPeriod($query,$request){

        if (!empty($request->input("fromDate"))) {
            $query->where("period",">=",$request->input("fromDate")." 00:00:00'");
        }

        if (!empty($request->input("toDate"))) {
            $query->where("period","<=",$request->input("toDate")." 23:59:59'");
        }

        return $query;
    }


    public function scopeSamePartnerOfCurrentUser($query)
    {
        $query->when(!Auth::user()->hasRole("Admin"), function($query){
            $query->whereHas("user",function($query){
                $query->whereHas("partners", function ($query) {
                    $query->whereIn("crm_user_has_partner.partner", Partner::allAssignedPartners()->get()->pluck("id")->toArray());
                });
            });
        });

        return $query;
    }

    public function scopeSameCampaignsOfCurrentUser($query)
    {

        $query->when(!Auth::user()->hasRole("Admin"), function($query){
            $query->whereHas("user",function($query){
                $query->whereHas("campaigns", function ($query) {
                    $query->whereIn("crm_user_has_campagna.campagna", Campagna::allUserCampaigns()->get()->pluck("id")->toArray());
                });
            });
        });


        return $query;
    }


}
