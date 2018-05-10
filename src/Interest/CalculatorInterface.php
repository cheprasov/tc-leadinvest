<?php

namespace TC\Lendinvest\Interest;


use TC\Lendinvest\Loan\Loan;

interface CalculatorInterface
{
    public function incrementInvestorEarn(Loan $Loan, string $dateBeg, string $dateEnd);
}
