<?php

namespace TC\Lendinvest\Loan\Investment;

use TC\Lendinvest\Investor\InvestorInterface;

interface InvestmentInterface
{
    /**
     * @return InvestorInterface
     */
    public function getInvestor(): InvestorInterface;

    /**
     * @return string
     */
    public function getDate(): string;

    /**
     * @return mixed
     */
    public function getAmount(): float;
}
