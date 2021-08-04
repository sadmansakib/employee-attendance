<?php


namespace App\Repositories\Attendance;

use App\Attendance;
use App\Repositories\BaseRepository;


class AttendanceRepository extends BaseRepository implements AttendanceRepositoryInterface
{
    protected $model;

    /**
     * AttendanceRepository constructor.
     * @param Attendance $model
     */
    public function __construct(Attendance $model)
    {
        $this->model = $model;
    }

    public function checkAttendance($date, $userId): bool
    {
        $attendance = $this->model::where('attending_date', $date)->where('user_id', $userId)->first();
        if ($attendance) {
            return true;
        } else {
            return false;
        }
    }

    public function totalEmployeesPresent($date): int
    {
        return count($this->model::where('attending_date', $date)->get());
    }

    public function currentLateEmployees($date): int
    {
        return count($this->model::where('attending_date', $date)->where('is_late',true)->get());
    }
}
