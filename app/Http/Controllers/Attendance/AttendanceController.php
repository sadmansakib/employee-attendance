<?php

namespace App\Http\Controllers\Attendance;

use App\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function give_attendance(Request $request){
        $validation = Validator::make($request->all(),[
            'attending_date' => ['required','date_format:Y-m-d'],
            'signin_time' => ['required','date_format:H:i'],
            'is_present' => ['required','boolean'],
        ]);
        if ($validation->fails()){
            return response()->json($validation->errors(),400);
        }
        $attendance = new Attendance;
        $attendance->attending_date = $request -> attending_date;
        $attendance->is_present = true;
        $attendance->user_id = Auth::id();
        $attendance->signin_time = $request -> signin_time;
        if (strtotime($request->signin_time) > strtotime('8:45')){
            $attendance->is_late = true;
        }else{
            $attendance->is_late = false;
        }
        $attendance->save();
        return response()->json($attendance);
    }
}

