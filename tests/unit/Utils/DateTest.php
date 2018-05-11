<?php

use \TC\Lendinvest\Utils\Date;

class DateTest extends \PHPUnit\Framework\TestCase
{
    public function providerGetIntersectData()
    {
        return [
            'set_' . __LINE__ => [
                'dateBeg1' => '2015-10-01',
                'dateEnd1' => '2015-10-31',
                'dateBeg2' => '2015-10-01',
                'dateEnd2' => '2015-10-31',
                'expect' => [
                    'intersect_days' => 31,
                    'days_in_month' => 31,
                    'month' => '2015-10',
                ],
            ],
            'set_' . __LINE__ => [
                'dateBeg1' => '2015-09-01',
                'dateEnd1' => '2015-11-31',
                'dateBeg2' => '2015-10-01',
                'dateEnd2' => '2015-10-10',
                'expect' => [
                    'intersect_days' => 10,
                    'days_in_month' => 31,
                    'month' => '2015-10',
                ],
            ],
            'set_' . __LINE__ => [
                'dateBeg1' => '2015-10-01',
                'dateEnd1' => '2015-10-31',
                'dateBeg2' => '2015-01-01',
                'dateEnd2' => '2015-12-31',
                'expect' => [
                    'intersect_days' => 31,
                    'days_in_month' => 31,
                    'month' => '2015-10',
                ],
            ],
            'set_' . __LINE__ => [
                'dateBeg1' => '2015-01-01',
                'dateEnd1' => '2015-12-31',
                'dateBeg2' => '2015-02-01',
                'dateEnd2' => '2015-02-28',
                'expect' => [
                    'intersect_days' => 28,
                    'days_in_month' => 28,
                    'month' => '2015-02',
                ],
            ],
            'set_' . __LINE__ => [
                'dateBeg1' => '2016-01-01',
                'dateEnd1' => '2016-12-31',
                'dateBeg2' => '2016-02-01',
                'dateEnd2' => '2016-02-28',
                'expect' => [
                    'intersect_days' => 28,
                    'days_in_month' => 29,
                    'month' => '2016-02',
                ],
            ],
            'set_' . __LINE__ => [
                'dateBeg1' => '2016-01-01',
                'dateEnd1' => '2016-01-31',
                'dateBeg2' => '2016-01-31',
                'dateEnd2' => '2016-02-29',
                'expect' => [
                    'intersect_days' => 1,
                    'days_in_month' => 31,
                    'month' => '2016-01',
                ],
            ],
            'set_' . __LINE__ => [
                'dateBeg1' => '2016-01-31',
                'dateEnd1' => '2016-02-29',
                'dateBeg2' => '2016-01-01',
                'dateEnd2' => '2016-01-31',
                'expect' => [
                    'intersect_days' => 1,
                    'days_in_month' => 31,
                    'month' => '2016-01',
                ],
            ],
            'set_' . __LINE__ => [
                'dateBeg1' => '2016-01-01',
                'dateEnd1' => '2016-01-31',
                'dateBeg2' => '2016-02-01',
                'dateEnd2' => '2016-02-29',
                'expect' => null,
            ],
            'set_' . __LINE__ => [
                'dateBeg1' => '2016-02-01',
                'dateEnd1' => '2016-02-29',
                'dateBeg2' => '2016-01-01',
                'dateEnd2' => '2016-01-31',
                'expect' => null,
            ],
        ];
    }

    /**
     * @see \TC\Lendinvest\Utils\Date::getIntersectData
     * @dataProvider providerGetIntersectData
     */
    public function testGetIntersectData($dateBeg1, $dateEnd1, $dateBeg2, $dateEnd2, $expect)
    {
        $result = Date::getIntersectData($dateBeg1, $dateEnd1, $dateBeg2, $dateEnd2);
        $this->assertSame($expect, $result);
    }

    public function providerIsFullMonthPeriod()
    {
        return [
            'set_' . __LINE__ => [
                'dateBeg' => '2015-01-01',
                'dateEnd' => '2015-01-31',
                'expect' => true,
            ],
            'set_' . __LINE__ => [
                'dateBeg' => '2015-01-01',
                'dateEnd' => '2015-01-30',
                'expect' => false,
            ],
            'set_' . __LINE__ => [
                'dateBeg' => '2016-02-01',
                'dateEnd' => '2016-02-31',
                'expect' => false,
            ],
            'set_' . __LINE__ => [
                'dateBeg' => '2016-02-01',
                'dateEnd' => '2016-02-29',
                'expect' => true,
            ],
        ];
    }

    /**
     * @see \TC\Lendinvest\Utils\Date::isFullMonthPeriod
     * @dataProvider providerIsFullMonthPeriod
     */
    public function testIsFullMonthPeriod($dateBeg, $dateEnd, $expect)
    {
        $result = Date::isFullMonthPeriod($dateBeg, $dateEnd);
        $this->assertSame($expect, $result);
    }

    public function providerIsCorrectDate()
    {
        return [
            'set_' . __LINE__ => [
                'date' => '2015-01-01',
                'expect' => true,
            ],
            'set_' . __LINE__ => [
                'date' => '2015-01-31',
                'expect' => true,
            ],
            'set_' . __LINE__ => [
                'date' => '2015-01-32',
                'expect' => false,
            ],
            'set_' . __LINE__ => [
                'date' => '2015-02-29',
                'expect' => false,
            ],
            'set_' . __LINE__ => [
                'date' => '2016-02-29',
                'expect' => true,
            ],
            'set_' . __LINE__ => [
                'date' => '2016-02-30',
                'expect' => false,
            ],
        ];
    }

    /**
     * @see \TC\Lendinvest\Utils\Date::isCorrectDate
     * @dataProvider providerIsCorrectDate
     */
    public function testIsCorrectDate($date, $expect)
    {
        $result = Date::isCorrectDate($date);
        $this->assertSame($expect, $result);
    }

    public function providerGetDaysCountByMonth()
    {
        return [
            'set_' . __LINE__ => [
                'year' => 2016,
                'month' => 1,
                'expect' => 31,
            ],
            'set_' . __LINE__ => [
                'year' => 2016,
                'month' => 2,
                'expect' => 29,
            ],
            'set_' . __LINE__ => [
                'year' => 2015,
                'month' => 2,
                'expect' => 28,
            ],
            'set_' . __LINE__ => [
                'year' => 2010,
                'month' => 10,
                'expect' => 31,
            ],
            'set_' . __LINE__ => [
                'year' => 2010,
                'month' => 13,
                'expect' => 0,
            ],
        ];
    }

    /**
     * @see \TC\Lendinvest\Utils\Date::getDaysCountByMonth
     * @dataProvider providerGetDaysCountByMonth
     */
    public function testGetDaysCountByMonth($year, $month, $expect)
    {
        $ReflectionClass = new ReflectionClass(Date::class);
        $Method = $ReflectionClass->getMethod('getDaysCountByMonth');
        $Method->setAccessible(true);
        $result = $Method->invoke(null, $year, $month);
        $this->assertSame($expect, $result);
    }
}
