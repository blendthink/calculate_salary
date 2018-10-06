<?php

namespace Models;


use ReflectionException;
use Utils\Year;

class Staff
{
    /**
     * @var int 仮の基本給
     */
    private $tempBaseSalary;

    /**
     * @var int １日の所定労働時間
     */
    private $dailyPrescribedWorkingHours;

    /**
     * @var int 固定残業時間
     */
    private $fixedOvertimeHour;

    public function __construct(int $tmpBaseSalary, int $dailyPrescribedWorkingHours, int $fixedOvertimeHour)
    {
        $this->tempBaseSalary = $tmpBaseSalary;
        $this->dailyPrescribedWorkingHours = $dailyPrescribedWorkingHours;
        $this->fixedOvertimeHour = $fixedOvertimeHour;
    }

    /**
     * （年間日数 − 年間休日日数）* １日の所定労働時間
     * @param int $year 西暦年
     * @return int 年間所定労働時間
     * @throws ReflectionException
     */
    private function yearPrescribedWorkingHour(int $year): int
    {
        // ここは会社の出勤日によって変わる
        // 今回は土日・祝日休み
        $utilYear = new Year($year);
        return ($utilYear->days() - $utilYear->holidayDays()) * $this->dailyPrescribedWorkingHours;
    }

    /**
     * @param int $year 西暦年
     * @return int 月間平均所定労働時間
     * @throws ReflectionException
     */
    private function monthlyAveragePrescribedWorkingHour(int $year): int
    {
        return $this->yearPrescribedWorkingHour($year) / 12;
    }

    /**
     * 基本給(仮)に固定残業代が含まれる場合、下記のような計算になる
     *
     * (基本給(仮)) = (基本給) + (基本給) / (月間平均所定労働時間) * (固定残業時間) * (割増賃金率)
     *
     * ↓変形して
     *
     * (基本給) = (基本給(仮)) / (1 + (固定残業時間) * (割増賃金率) / (月間平均所定労働時間))
     *
     * @param int $year 西暦年
     * @return int 基本給
     * @throws ReflectionException
     */
    public function baseSalary(int $year): int
    {
        $monthlyAveragePrescribedWorkingHour = $this->monthlyAveragePrescribedWorkingHour($year);

        return $this->tempBaseSalary / (1 + $this->fixedOvertimeHour * 1.25 / $monthlyAveragePrescribedWorkingHour);
    }

    /**
     * @param int $year 西暦年
     * @return int １時間あたりの基本給
     * @throws ReflectionException
     */
    public function baseSalaryPerHour(int $year): int
    {
        return $this->baseSalary($year) / $this->monthlyAveragePrescribedWorkingHour($year);
    }
}