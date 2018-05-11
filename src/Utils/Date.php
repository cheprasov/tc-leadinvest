<?php

namespace TC\Lendinvest\Utils;

class Date
{
    const REG_DATE = '/^(?P<year>\d{4})-(?P<month>\d{2})-(?P<day>\d{2})$/';

    const COUNT_DAYS_BY_MONTH = [
        1 => 31,
        2 => 28,
        3 => 31,
        4 => 30,
        5 => 31,
        6 => 30,
        7 => 31,
        8 => 31,
        9 => 30,
        10 => 31,
        11 => 30,
        12 => 31,
    ];

    /**
     * @param int $year
     * @param int $month
     * @return int
     */
    protected static function getDaysCountByMonth(int $year, int $month): int
    {
        $count = self::COUNT_DAYS_BY_MONTH[$month] ?? 0;
        if (!$count) {
            return 0;
        }
        if ($month === 2) {
            $isLeapYear = ($year % 100 === 0) ? ($year % 400 === 0) : ($year % 4 === 0);
            if ($isLeapYear) {
                $count += 1;
            }
        }

        return $count;
    }

    /**
     * @param string $date
     * @return bool
     */
    public static function isCorrectDate(string $date): bool
    {
        if (!preg_match(self::REG_DATE, $date, $match)) {
            return false;
        }
        return checkdate($match['month'], $match['day'], $match['year']);
    }

    /**
     * @param string $dateBeg
     * @param string $dateEnd
     * @return bool
     */
    public static function isFullMonthPeriod(string $dateBeg, string $dateEnd): bool
    {
        if (!preg_match(self::REG_DATE, $dateBeg, $match1)) {
            return false;
        }
        if (!preg_match(self::REG_DATE, $dateEnd, $match2)) {
            return false;
        }
        if ((int)$match1['day'] !== 1) {
            return false;
        }
        if ((int)$match2['day'] !== static::getDaysCountByMonth($match2['year'], $match2['month'])) {
            return false;
        }
        return true;
    }

    /**
     * @param string $dateBeg1
     * @param string $dateEnd1
     * @param string $dateBeg2
     * @param string $dateEnd2
     * @return array|null
     */
    public static function getIntersectData($dateBeg1, $dateEnd1, $dateBeg2, $dateEnd2)
    {
        if ($dateEnd1 < $dateBeg2 || $dateBeg1 > $dateEnd2) {
            return null;
        }
        $beg = max($dateBeg1, $dateBeg2);
        $end = min($dateEnd1, $dateEnd2);
        $date1 = new \DateTime($beg);
        $date2 = new \DateTime($end);

        return [
            'intersect_days' => (int)$date2->diff($date1)->format("%a") + 1,
            'days_in_month' => static::getDaysCountByMonth((int)$date1->format('Y'), (int)$date1->format('n')),
            'month' => $date1->format('Y-m'),
        ];
    }
}
