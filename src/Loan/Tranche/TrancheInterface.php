<?php

namespace TC\Lendinvest\Loan\Tranche;

use TC\Lendinvest\Investor\InvestorInterface;
use TC\Lendinvest\Loan\LoanInterface;

interface TrancheInterface
{
    /**
     * @param LoanInterface $Loan
     */
    public function setLoad(LoanInterface $Loan);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return float
     */
    public function getMaxAmount(): float;

    /**
     * @return float
     */
    public function getPercentage(): float;

    /**
     * @return \TC\Lendinvest\Loan\Investment\InvestmentInterface[]
     */
    public function getInvestments(): array;

    /**
     * @param InvestorInterface $Investor
     * @param string $date
     * @param float $amount
     * @return bool
     */
    public function makeInvestment(InvestorInterface $Investor, string $date, float $amount): bool;
}
