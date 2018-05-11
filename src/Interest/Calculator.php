<?php

namespace TC\Lendinvest\Interest;

use TC\Lendinvest\Exception\IncorrectDateException;
use TC\Lendinvest\Loan\LoanInterface;
use TC\Lendinvest\Utils\Date;

class Calculator implements CalculatorInterface
{
    /**
     * @inheritdoc
     */
    public function incrementInvestorEarnByPeriod(LoanInterface $Loan, string $dateBeg, string $dateEnd)
    {
        if (!Date::isCorrectDate($dateBeg) || !Date::isCorrectDate($dateEnd) || $dateBeg >= $dateEnd) {
            throw new IncorrectDateException();
        }
        if (!Date::isFullMonthPeriod($dateBeg, $dateEnd)) {
            throw new IncorrectDateException('For test, I will calculate only for one whole month period');
        }
        if ($Loan->getDateBeg() > $dateEnd || $Loan->getDateEnd() < $dateBeg) {
            // Skip calculation, not need check
            return;
        }

        foreach ($Loan->getTranches() as $Tranche) {
            foreach ($Tranche->getInvestments() as $Investment) {
                $intersectData = Date::getIntersectData($dateBeg, $dateEnd, $Investment->getDate(), $Loan->getDateEnd());
                if (empty($intersectData['intersect_days']) || empty($intersectData['days_in_month'])) {
                    continue;
                }
                $k = $intersectData['intersect_days'] / $intersectData['days_in_month'];
                $earn = round($Investment->getAmount() * $k * $Tranche->getPercentage(), 2);
                if ($earn) {
                    $Investment->getInvestor()->incrementAmount($earn);
                }
            }
        }
    }
}
