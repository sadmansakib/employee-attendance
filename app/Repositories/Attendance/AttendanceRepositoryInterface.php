<?php


namespace App\Repositories\Attendance;


use App\Repositories\RepositoryInterface;

interface AttendanceRepositoryInterface extends RepositoryInterface
{
    public function checkAttendance($date, $userId): bool;

    public function totalEmployeesPresent($date): int;

    public function currentLateEmployees($date): int;
}
