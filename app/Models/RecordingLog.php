<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordingLog extends Model
{
    protected $table = 'recording_log';
    protected $primaryKey = 'recording_id';

    protected $fillable = [
        'recording_id',
        'channel',
        'server_ip',
        'extension',
        'start_time',
        'start_epoch',
        'end_time',
        'end_epoch',
        'length_in_sec',
        'length_in_min',
        'filename',
        'location',
        'lead_id',
        'user',
        'vicidial_id',

    ];


    protected $dates = [
        'start_time',
        'end_time',

    ];
    public $timestamps = false;

    protected $appends = ['resource_url','telefono','campagna', 'rewrite_location'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/recording-log/'.$this->getKey());
    }

    public function getRewriteLocationAttribute(){
        $connName = $this->getConnectionName();
        $connection = config("database.connections.$connName");
        if(isset($connection["db_rewrite_host"]) ? $connection["db_rewrite_host"] : ''){
            $recSearch = !empty($connection["db_rewrite_search"]) ? $connection["db_rewrite_search"] : null;
            $recReplace = !empty($connection["db_rewrite_replace"]) ? $connection["db_rewrite_replace"] : null;
            if($recSearch && $recReplace){
                return str_replace($recSearch,$recReplace,$this->location);
            }
        }

        return $this->location;
    }

    public function getCampagnaAttribute(){
        $t = explode("_",$this->filename);
        if(count($t)>0)
            return $t[count($t)-1];

        return '';
    }

    public function getTelefonoAttribute(){
        $t = explode("_",$this->filename);
        if(count($t)>=4)
            return $t[count($t)-3];

        return '';
    }
}
