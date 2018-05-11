<?php

namespace TC\Lendinvest\Loan\Tranche;

use TC\Lendinvest\Exception\Exception;
use TC\Lendinvest\Exception\IncorrectDateException;
use TC\Lendinvest\Exception\OutOfTrancheMaxAmountException;
use TC\Lendinvest\Investor\InvestorInterface;
use TC\Lendinvest\Loan\Investment\Investment;
use TC\Lendinvest\Loan\LoanInterface;
use TC\Lendinvest\Utils\Date;

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
     * @var LoanInterface|null
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
     * @inheritdoc
     */
    public function setLoad(LoanInterface $Loan)
    {
        $this->Loan = $Loan;
    }

    /**
     * @return LoanInterface
     * @throws Exception
     */
    protected function getLoad(): LoanInterface
    {
        if (!$this->Loan) {
            throw new Exception('Loan should be defined');
        }
        return $this->Loan;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getMaxAmount(): float
    {
        return $this->getMaxAmount();
    }

    /**
     * @inheritdoc
     */
    public function getPercentage(): float
    {
        return $this->percentage;
    }

    /**
     * @inheritdoc
     */
    public function getInvestments(): array
    {
        return $this->investments;
    }

    /**
     * @inheritdoc
     * @throws OutOfTrancheMaxAmountException
     * @throws IncorrectDateException
     */
    public function makeInvestment(InvestorInterface $Investor, string $date, float $amount): bool
    {
        if ($this->allowedAmount < $amount) {
            throw new OutOfTrancheMaxAmountException();
        }
        if (!Date::isCorrectDate($date)) {
            throw new IncorrectDateException();
        }
        $Loan = $this->getLoad();
        if ($date < $Loan->getDateBeg() || $date >= $Loan->getDateEnd()) {
            throw new IncorrectDateException(
                "Investment date should be between {$Loan->getDateBeg()} and {$Loan->getDateEnd()}"
            );
        }
        $this->investments[] = new Investment($Investor, $date, $amount);
        $this->allowedAmount -= $amount;
        return true;
    }
}
