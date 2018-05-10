<?php

namespace TC\Lendinvest\Loan;

use TC\Lendinvest\Investor\Investor;

class Investment
{
    /**
     * @var Investor
     */
    protected $Investor;

    /**
     * @var string
     */
    protected $date;

    /**
     * @param float
     */
    protected $amount;

    /**
     * @param Investor $Investor
     * @param string $date
     * @param float $amount
     */
    public function __construct(Investor $Investor, string $date, float $amount)
    {
        $this->Investor = $Investor;
        $this->date = $date;
        $this->amount = $amount;
    }
}
