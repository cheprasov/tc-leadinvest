<?php

namespace TC\Lendinvest\Loan\Tranche;

use TC\Lendinvest\Investor\Investor;
use TC\Lendinvest\Loan\Investment;
use TC\Lendinvest\Loan\Loan;

interface TrancheInterface
{
    /**
     * @param Loan $Loan
     */
    public function setLoad(Loan $Loan);

    /**
     * @return Loan|null
     */
    public function getLoad();

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
     * @return Investment[]
     */
    public function getInvestments(): array;

    /**
     * @param Investor $Investor
     * @param $date $amount
     * @return bool
     */
    public function madeInvestment(Investor $Investor, string $date, float $amount): bool;
}
