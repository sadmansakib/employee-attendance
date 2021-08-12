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
        $attendance = $this->model::where([
            ['attending_date', $date],
            ['user_id', $userId]
        ])->first();

        return (bool)$attendance;
    }

    public function totalEmployeesPresent($date): int
    {
        return count($this->model::where('attending_date', $date)->get());
    }

    public function currentLateEmployees($date): int
    {
        return count($this->model::where([
            ['attending_date', $date],
            ['is_late', true]
        ])->get());
    }
}
