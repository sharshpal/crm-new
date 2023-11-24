<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VicidialUser extends Model
{
    protected $table = 'vicidial_users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'full_name',
        'user',
        'user_group',
    ];


    protected $dates = [
    ];

    public $timestamps = false;

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/vc-user/'.$this->getKey());
    }

}
