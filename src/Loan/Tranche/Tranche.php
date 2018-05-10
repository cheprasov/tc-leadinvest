<?php

namespace TC\Lendinvest\Loan\Tranche;

use TC\Lendinvest\Exception\OutOfTrancheMaxAmountException;
use TC\Lendinvest\Investor\Investor;
use TC\Lendinvest\Loan\Investment;
use TC\Lendinvest\Loan\Loan;

class Tranche implements TrancheInterface
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var float
     */
    protected $percentage;

    /**
     * @var float
     */
    protected $maxAmount;

    /**
     * @var float;
     */
    protected $allowedAmount;

    /**
     * @var Loan|null
     */
    protected $Loan;

    /**
     * @var array
     */
    protected $investments = [];

    /**
     * @param string $name
     * @param float $percentage
     * @param int $maxAmount
     */
    public function __construct(string $name, float $percentage, float $maxAmount)
    {
        $this->name = $name;
        $this->percentage = $percentage;
        $this->maxAmount = $maxAmount;
        $this->allowedAmount = $maxAmount;
    }

    /**
     * @param Loan $Loan
     */
    public function setLoad(Loan $Loan)
    {
        $this->Loan = $Loan;
    }

    /**
     * @return Loan|null
     */
    public function getLoad()
    {
        $this->Loan;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getMaxAmount(): float
    {
        return $this->getMaxAmount();
    }

    /**
     * @return float
     */
    public function getPercentage(): float
    {
        return $this->percentage;
    }

    /**
     * @return Investment[]
     */
    public function getInvestments(): array
    {
        return $this->investments;
    }

    /**
     * @param Investor $Investor
     * @param string $date
     * @param float $amount
     * @return bool
     */
    public function madeInvestment(Investor $Investor, string $date, float $amount): bool
    {
        $Investor->incrementAmount(-$amount);
        if ($this->allowedAmount < $amount) {
            throw new OutOfTrancheMaxAmountException();
        }
        $this->allowedAmount -= $amount;
        $Investment = new Investment($Investor, $date, $amount);
        return true;
    }
}
