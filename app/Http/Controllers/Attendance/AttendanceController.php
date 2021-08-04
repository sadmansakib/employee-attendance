<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Repositories\Attendance\AttendanceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    private $attendanceRepository;

    /**
     * AttendanceController constructor.
     * @param AttendanceRepositoryInterface $attendanceRepository
     */
    public function __construct(AttendanceRepositoryInterface $attendanceRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
    }

    public function giveAttendance(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'attending_date' => ['required', 'date_format:Y-m-d'],
            'signin_time' => ['required', 'date_format:H:i'],
            'is_present' => ['required', 'boolean'],
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $userID = auth()->id();

        if ($this->attendanceRepository->checkAttendance($request->attending_date, $userID)) {
            return response()->json(['error' => 'attendance already recorded']);
        }

        $islate = strtotime($request->signin_time) > strtotime('8:45');
        $attendance = $this->attendanceRepository->create(
            ['attending_date' => $request->attending_date,
                'is_present' => true,
                'user_id' => $userID,
                'signin_time' => $request->signin_time,
                'is_late' => $islate]
        );

        return response()->json($attendance);
    }

    public function employeesPresentToday()
    {
        return response()->json($this->attendanceRepository
            ->totalEmployeesPresent(date('Y-m-d')));
    }

    public function lateEmployeesPresentToday()
    {
        return response()->json($this->attendanceRepository->currentLateEmployees(date('Y-m-d')));
    }
}

