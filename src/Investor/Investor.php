<?php

namespace TC\Lendinvest\Investor;

use TC\Lendinvest\Exception\OutOfOverdraftException;

class Investor implements InvestorInterface
{
    /**
     * @var float
     */
    protected $amount = 0;

    /**
     * @param float $amount
     */
    public function __construct(float $amount)
    {
        $this->incrementAmount($amount);
    }

    /**
     * @return float|int
     */
    protected function getMinAmount(): float
    {
        if ($this instanceof OverdraftInterface) {
            return -$this->getOverdraftAmount();
        }
        return 0;
    }

    /**
     * Investor without overdraft
     * @inheritdoc
     * @throws OutOfOverdraftException
     */
    public function incrementAmount(float $amount): float
    {
        $newAmount = $this->amount + $amount;
        if ($newAmount < $this->getMinAmount()) {
            throw new OutOfOverdraftException("Amount: {$this->amount}, incr: {$amount}");
        }
        $this->amount = $newAmount;
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getAmount(): float
    {
        return $this->amount;
    }
}
