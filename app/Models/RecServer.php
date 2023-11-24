<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecServer extends Model
{
    protected $table = 'rec_server';

    protected $fillable = [
        'name',
        'type',
        'db_host',
        'db_driver',
        'db_port',
        'db_name',
        'db_user',
        'db_password',
        'db_rewrite_host',
        'db_rewrite_search',
        'db_rewrite_replace',
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    protected $dates = [

    ];
    public $timestamps = true;

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/rec-server/'.$this->getKey());
    }

    public function getSelfConnectionName(){
        return "rec-server_{$this->id}";
    }

    public static function getAllRecServerList(){
        return RecServer::all()->map(function ($recServer) {
            return [
                'id' => $recServer->id,
                'name' => $recServer->name,
            ];
        })->toArray();
    }
}
