<?php

namespace TC\Lendinvest\Investor;

interface InvestorInterface
{
    /**
     * @param float $amount
     * @return float new amount after increment
     */
    public function incrementAmount(float $amount): float;

    /**
     * @return float
     */
    public function getAmount(): float;
}
