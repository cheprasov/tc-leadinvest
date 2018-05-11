<?php

namespace TC\Lendinvest\Loan\Investment;

use TC\Lendinvest\Exception\IncorrectAmountException;
use TC\Lendinvest\Investor\InvestorInterface;

class Investment implements InvestmentInterface
{
    /**
     * @var InvestorInterface
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
     * @param InvestorInterface $Investor
     * @param string $date
     * @param float $amount
     */
    public function __construct(InvestorInterface $Investor, string $date, float $amount)
    {
        if ($amount <= 0) {
            throw new IncorrectAmountException('Amount should be positive');
        }
        $this->Investor = $Investor;
        $this->date = $date;
        $this->amount = $amount;

        $this->Investor->incrementAmount(-$amount);
    }

    /**
     * @return InvestorInterface
     */
    public function getInvestor(): InvestorInterface
    {
        return $this->Investor;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getAmount(): float
    {
        return $this->amount;
    }
}
