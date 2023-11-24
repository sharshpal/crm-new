<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SysSetting extends Model
{
    protected $fillable = [
        'crm_user',
        'key',
        'value',
    ];


    protected $dates = [

    ];

    public $timestamps = false;

    protected $appends = ['resource_url'];

    protected $casts = [
        'value' => 'array'
    ];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/sys-settings/'.$this->getKey());
    }

    public function crm_user()
    {
        return $this->belongsTo('App\Models\CrmUser', 'crm_user');
    }


    public static function getTemplateSettings(){

        $sys_settings = self::getSysTemplateSettings();

        $colors = [];
        if(!empty($sys_settings->value)){
            $colors = $sys_settings->value;
        }

        if(Auth::user()){
            $user_settings = SysSetting::where("crm_user",Auth::user()->id)->where("key","template")->get()->first();
            if($user_settings){
                if(!empty($user_settings->value)){
                    $colors = $user_settings->value;
                }
            }
        }

        if(!empty($colors["colors"])){
            $colors = $colors["colors"];
        }


        $str = "";
        foreach($colors as $color){
            $str .= "--{$color['id']}: {$color['value']} !important; ";
        }
        if(strlen($str)){
            $str = "<style> body{ {$str} } </style>";
        }

        echo $str;
    }

    public static function getSysTemplateSettings(){
        return SysSetting::whereNull("crm_user")->where("key","template")->get()->first();
    }

}
