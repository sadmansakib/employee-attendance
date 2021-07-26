<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed attending_date
 * @property bool|mixed is_present
 * @property int|mixed|null user_id
 * @property mixed signin_time
 * @property bool|mixed is_late
 */
class Attendance extends Model
{
    protected $fillable = [
        'attending_date', 'signin_time', 'is_present', 'is_late', 'user_id'
    ];

    public function employees()
    {
        return $this->belongsToMany('App\User');
    }
}
