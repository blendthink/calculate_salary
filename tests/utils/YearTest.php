<?php

namespace Tests\Utils;


use Utils\Year;
use PHPUnit\Framework\TestCase;

class YearTest extends TestCase
{
    static function mockDays()
    {
        return [
            [2016, 366],
            [2017, 365],
            [2018, 365],
            [2019, 365],
            [2020, 366],
            [2021, 365],
            [2022, 365],
            [2023, 365],
            [2024, 366],
            [2100, 365]
        ];
    }

    /**
     * @dataProvider mockDays
     * @param int $year
     * @param int $expected
     */
    public function testDays(int $year, int $expected)
    {
        $utilYear = new Year($year);

        self::assertEquals($expected, $utilYear->days());
    }


    static function mockWeekendDays()
    {
        return [
            [2016, 105],
            [2017, 105],
            [2018, 104],
            [2019, 104],
            [2020, 104],
            [2021, 104],
            [2022, 105]
        ];
    }

    /**
     * @dataProvider mockWeekendDays
     * @param int $year
     * @param int $expected
     */
    public function testWeekendDays(int $year, int $expected)
    {
        $utilYear = new Year($year);

        self::assertEquals($expected, $utilYear->weekendDays());
    }


    static function mockPublicHolidayDays()
    {
        return [
            [2016, 17],
            [2017, 17],
            [2018, 20],
            [2019, 19],
            [2020, 17],
            [2021, 16]
        ];
    }

    /**
     * @dataProvider mockPublicHolidayDays
     * @param int $year
     * @param int $expected
     * @throws \ReflectionException
     */
    public function testPublicHolidayDays(int $year, int $expected)
    {
        $utilYear = new Year($year);

        self::assertEquals($expected, $utilYear->publicHolidayDays());
    }


    static function mockYearWeekendAndPublicHolidayDays()
    {
        return [
            [2016, 1],
            [2017, 5],
            [2018, 7],
            [2019, 5],
            [2020, 1]
        ];
    }

    /**
     * @dataProvider mockYearWeekendAndPublicHolidayDays
     * @param int $year
     * @param int $expected
     * @throws \ReflectionException
     */
    public function testWeekendAndPublicHolidayDays(int $year, int $expected)
    {
        $utilYear = new Year($year);

        self::assertEquals($expected, $utilYear->weekendAndPublicHolidayDays());
    }


    static function mockHolidayDays()
    {
        return [
            [2016, 121],
            [2017, 117],
            [2018, 117],
            [2019, 118],
            [2020, 120],
            [2021, 119]
        ];
    }

    /**
     * @dataProvider mockHolidayDays
     * @param int $year
     * @param int $expected
     * @throws \ReflectionException
     */
    public function testHolidayDays(int $year, int $expected)
    {
        $utilYear = new Year($year);

        self::assertEquals($expected, $utilYear->holidayDays());
    }


    static function mockPublicHolidays()
    {
        return [
            [
                2018,
                [
                    '2018-01-01', '2018-01-08', '2018-02-11', '2018-02-12',
                    '2018-03-21', '2018-04-29', '2018-04-30', '2018-05-03',
                    '2018-05-04', '2018-05-05', '2018-07-16', '2018-08-11',
                    '2018-09-17', '2018-09-23', '2018-09-24', '2018-10-08',
                    '2018-11-03', '2018-11-23', '2018-12-23', '2018-12-24'
                ]
            ]
        ];
    }

    /**
     * @dataProvider mockPublicHolidays
     * @param int $year
     * @param string[] $expected
     * @throws \ReflectionException
     */
    public function testPublicHolidays(int $year, array $expected)
    {
        $utilYear = new Year($year);

        $publicHolidays = $utilYear->publicHolidays();

        self::assertEquals($expected, $publicHolidays);
    }
}