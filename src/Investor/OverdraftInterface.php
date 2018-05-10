<?php

namespace TC\Lendinvest\Investor;

interface OverdraftInterface
{
    /**
     * @return int
     */
    public function getOverdraftAmount(): float;
}
