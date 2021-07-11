<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'attending_date','signin_time','is_present','is_late',
    ];

    public function employees(){
        return $this->belongsToMany('App\User');
    }
}
