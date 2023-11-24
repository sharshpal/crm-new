<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VicidialAgentLog extends Model
{
    protected $table = 'vicidial_agent_log';
    protected $primaryKey = 'agent_log_id';

    protected $fillable = [
        'agent_log_id',
        'user',
        'server_ip',
        'event_time',
        'campaign_id',
        'pause_sec',
        'wait_sec',
        'talk_sec',
        'dispo_sec',
        'status',
        'user_group',
        'dead_sec',
        'uniqueid',
        'pause_type',
    ];

    protected $dates = [
        'event_time',

    ];
    public $timestamps = false;

    protected $appends = ['resource_url','after_call_work','login_time','effective_time','pause_hour','wait_hour','talk_hour','after_call_work_hour','login_time_hour','effective_time_hour','pause_perc','wait_perc','talk_perc','after_call_work_perc'];

    /* ************************ ACCESSOR ************************* */

    public function user()
    {
        return $this->belongsTo('App\Models\VicidialUser', 'user', 'user');
    }


    public function secToTimeFormat($seconds){
        return sprintf('%02d:%02d:%02d', ($seconds/ 3600),($seconds/ 60 % 60), $seconds % 60);
    }

    public function secToHour($sec){
        return round($sec/60/60,2);
    }

    public function getResourceUrlAttribute()
    {
        return url('/agent-log/'.$this->getKey());
    }

    public function getAfterCallWorkAttribute()
    {
        //return $this->dispo_sec + $this->dead_sec;
        return $this->dispo_sec;
    }

    public function getLoginTimeAttribute()
    {
        //return $this->pause_sec + $this->wait_sec + $this->talk_sec + $this->dispo_sec + $this->dead_sec;
        return $this->pause_sec + $this->wait_sec + $this->talk_sec + $this->dispo_sec;
    }

    public function getEffectiveTimeAttribute()
    {

        $method = env("PAYTIME_COMPUTE_METHOD","METHOD_1");

        //tempo utile al calcolo
        $work = $this->wait_sec + $this->talk_sec + $this->dispo_sec;  //+ $this->dead_sec;

        //nel caso di METHOD_3 non devo considerare dispo_sec
        $work -= $method == "METHOD_3" ? $this->dispo_sec : 0;

        //METHOD_1 15 minuti di pausa ogni 2 ore di lavoro
        $pauseM1 = $method == "METHOD_1" ? intdiv(($work/60/60)-2,2)*15*60 : 0;

        //METHOD_2 Aggiungo 3.75 minuti di pausa ogni 30 di lavoro
        $pauseM2 = $method == "METHOD_2" ? (intdiv($work/60,30) * 3.75)*60 : 0;

        //METHOD_3  3.75 minuti di pausa ogni 30 di lavoro
        //METHOD_3  2.7 minuti di a.c.w ogni 30 di lavoro
        $pauseM3 = $method == "METHOD_3" ? (intdiv($work/60,30) * 3.75)*60 : 0;
        $aftercwM3 = $method == "METHOD_3" ? (intdiv($work/60,30) * 2.7)*60 : 0;

        //dd($method,$work,$pauseM1,$pauseM2,$pauseM3,$aftercwM3,$work + $pauseM1 + $pauseM2 + $pauseM3 + $aftercwM3);

        return $work + $pauseM1 + $pauseM2 + $pauseM3 + $aftercwM3;
    }

    public function getAfterCallWorkHourAttribute()
    {
        return $this->secToTimeFormat($this->getAfterCallWorkAttribute());
    }

    public function getLoginTimeHourAttribute()
    {
        return $this->secToTimeFormat($this->getLoginTimeAttribute());
    }

    public function getEffectiveTimeHourAttribute()
    {
        return $this->secToTimeFormat($this->getEffectiveTimeAttribute());
    }

    public function getPauseHourAttribute()
    {
        return $this->secToTimeFormat($this->pause_sec);
    }

    public function getWaitHourAttribute()
    {
        return $this->secToTimeFormat($this->wait_sec);
    }

    public function getTalkHourAttribute()
    {
        return $this->secToTimeFormat($this->talk_sec);
    }



    public function getPausePercAttribute()
    {
        return $this->getPercentage($this->pause_sec);
    }

    public function getWaitPercAttribute()
    {
        return $this->getPercentage($this->wait_sec);
    }

    public function getTalkPercAttribute()
    {
        return $this->getPercentage($this->talk_sec);
    }
    public function getAfterCallWorkPercAttribute()
    {
        return $this->getPercentage($this->getAfterCallWorkAttribute());
    }

    public function getPercentage($attr){

        return $this->getLoginTimeAttribute() > 0 ? round($attr*100/$this->getLoginTimeAttribute(),2) : 0;
    }


    public function scopeEventTimeFilterQuery($query, $request)
    {

        if (!empty($request->input("fromDate"))) {
            $query->where("event_time", ">=", $request->input("fromDate") . " 00:00:00");
        }
        if (!empty($request->input("toDate"))) {
            $query->where("event_time", "<=", $request->input("toDate") . " 23:59:59");
        }

        return $query;
    }

    public function scopeTimeStatQuery(Builder $query, $request,$queryColumns)
    {

        foreach($queryColumns as $col){
            $query->addSelect($col);
        }

        $query->selectSub(function($query) {
            return $query->selectRaw('SUM(pause_sec)');
        }, 'pause_sec');

        $query->selectSub(function($query) {
            return $query->selectRaw('SUM(wait_sec)');
        }, 'wait_sec');

        $query->selectSub(function($query) {
            return $query->selectRaw('SUM(talk_sec)');
        }, 'talk_sec');

        $query->selectSub(function($query) {
            return $query->selectRaw('SUM(dispo_sec)');
        }, 'dispo_sec');

        $query->selectSub(function($query) {
            return $query->selectRaw('SUM(dead_sec)');
        }, 'dead_sec');



        $query->with(['user' => function ($query) use ($request){
            $query->select('user', 'full_name', 'user_group');
            if($request->has("search")){
                $query->where("user", "LIKE", '%' . $request->input("search"). '%');
                $query->orWhere("full_name", "LIKE" , '%' . $request->input("search"). '%');
            }
        }]);


        $query->groupBy('user');

        return $query;
    }


    public function scopeStatusStatQuery(Builder $query, $request,$queryColumns)
    {

        $query->select("user",'status');
        $query->selectRaw('COUNT(*) as calls');

        //$query->havingStatus();

        $query->with(['user' => function ($query) use ($request) {
            $query->select('user', 'full_name', 'user_group');
            if($request->has("search")){
                $query->where("user", "LIKE", '%' . $request->input("search"). '%');
                $query->orWhere("full_name", "LIKE" , '%' . $request->input("search"). '%');
            }
            $query->orderBy("full_name");
        }]);

        $query->groupBy('user','status');
        //$query->orderBy('vicidial_users.full_name','asc');
        //$query->orderBy('status','asc');

        return $query;
    }

    public function scopeHavingStatus(Builder $query){
        $query->whereNotNull("status")->where("status",'<>','');
        return $query;
    }

}

