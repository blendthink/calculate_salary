<?php

namespace Utils;


use DateTime;
use Carbon\Carbon;
use Yasumi\Yasumi;
use ReflectionException;

/**
 * Class Year
 * @package Utils
 *
 * static method の方がメモリ消費量は少ないがあまり気にしない
 */
class Year
{
    /**
     * @var int 西暦年
     */
    private $year;

    /**
     * Year constructor.
     * @param int $year 西暦年
     */
    public function __construct(int $year)
    {
        $this->year = $year;
    }

    /**
     * @return int 日数
     */
    public function days(): int
    {
        $current = sprintf('%d-01-01 00:00:00', $this->year);
        $next = sprintf('%d-01-01 00:00:00', $this->year + 1);

        $currentYear = new DateTime($current);
        $nextYear = new DateTime($next);

        $diff = $nextYear->diff($currentYear);

        return $diff->days;
    }

    /**
     * @return int 土日の日数
     */
    public function weekendDays(): int
    {
        $current = sprintf('%d-01-01 00:00:00', $this->year);
        $next = sprintf('%d-01-01 00:00:00', $this->year + 1);

        $currentYear = new Carbon($current);
        $nextYear = new Carbon($next);

        return $nextYear->diffInDaysFiltered(
            function (Carbon $date) {
                return $date->isWeekend();
            }, $currentYear);
    }

    /**
     * @return string[] 祝日
     * @throws ReflectionException
     */
    public function publicHolidays(): array
    {
        $holidays = Yasumi::create('Japan', $this->year, 'ja_JP');

        return array_values($holidays->getHolidayDates());
    }

    /**
     * @return int 祝日の日数
     * @throws ReflectionException
     */
    public function publicHolidayDays(): int
    {
        return count($this->publicHolidays());
    }

    /**
     * @return int 土日かつ祝日の日数
     * @throws ReflectionException
     */
    public function weekendAndPublicHolidayDays(): int
    {
        $publicHolidays = $this->publicHolidays();

        $count = 0;
        foreach ($publicHolidays as $publicHoliday) {
            if ((new Carbon($publicHoliday))->isWeekend()) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * @return int 休日の日数
     * @throws ReflectionException
     */
    public function holidayDays(): int
    {
        return $this->weekendDays() + $this->publicHolidayDays() - $this->weekendAndPublicHolidayDays();
    }
}