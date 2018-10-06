<?php

namespace Models;


use ReflectionException;

class Attendance
{
    /**
     * @var int 西暦年
     */
    private $year;

    /**
     * @var int 残業時間
     */
    private $overtimeHour;

    /**
     * @var Staff スタッフ
     */
    private $staff;

    public function __construct(int $year, int $overtimeHour, Staff $staff)
    {
        $this->year = $year;
        $this->overtimeHour = $overtimeHour;
        $this->staff = $staff;
    }

    /**
     * @return int 残業代
     * @throws ReflectionException
     */
    public function overtimePay(): int
    {
        return $this->staff->baseSalaryPerHour($this->year) * $this->overtimeHour * 1.25;
    }

    /**
     *
     * @return int 給料
     * @throws ReflectionException
     */
    public function salary(): int
    {
        return $this->staff->baseSalary($this->year) + $this->overtimePay();
    }
}