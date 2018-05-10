<?php

namespace TC\Lendinvest\Interest;


use TC\Lendinvest\Loan\Loan;

class Calculator implements CalculatorInterface
{
    /**
     * @param Loan $Loan
     * @param string $dateBeg
     * @param string $dateEnd
     */
    public function incrementInvestorEarn(Loan $Loan, string $dateBeg, string $dateEnd)
    {
    }
}
