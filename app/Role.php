<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'type',
    ];

    public function employee(){
        return $this->belongsTo('App\User');
    }
}
