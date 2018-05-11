<?php

namespace TC\Lendinvest\Loan;

use TC\Lendinvest\Loan\Tranche\TrancheInterface;

interface LoanInterface
{
    /**
     * @param TrancheInterface $Tranche
     * @return bool
     */
    public function addTranche(TrancheInterface $Tranche): bool;

    /**
     * @return TrancheInterface[]
     */
    public function getTranches(): array;

    /**
     * @return string
     */
    public function getDateBeg(): string;

    /**
     * @return string
     */
    public function getDateEnd(): string;
}
