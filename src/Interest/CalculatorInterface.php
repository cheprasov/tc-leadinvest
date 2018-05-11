<?php

namespace TC\Lendinvest\Interest;

use TC\Lendinvest\Loan\LoanInterface;

interface CalculatorInterface
{
    public function incrementInvestorEarnByPeriod(LoanInterface $Loan, string $dateBeg, string $dateEnd);
}
