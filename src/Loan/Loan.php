<?php

namespace TC\Lendinvest\Loan;

use TC\Lendinvest\Exception\DuplicateTrancheForLoadException;
use TC\Lendinvest\Loan\Tranche\TrancheInterface;

class Loan {

    /**
     * @var string|null
     */
    protected $begDate;

    /**
     * @var string|null
     */
    protected $endDate;

    /**
     * @var array
     */
    protected $tranches = [];

    /**
     * @param string $begDate
     * @param string $endDate
     */
    public function __construct(string $begDate, string $endDate)
    {
        if ($begDate >= $endDate) {
        }
        $this->begDate = $begDate;
        $this->endDate = $endDate;
    }

    /**
     * @param TrancheInterface $Tranche
     * @return bool
     * @throws DuplicateTrancheForLoadException
     */
    public function addTranche(TrancheInterface $Tranche): bool
    {
        if ($this->tranches[$Tranche->getName()] ?? false) {
            throw new DuplicateTrancheForLoadException();
        }
        $this->tranches[$Tranche->getName()] = $Tranche;
        $Tranche->setLoad($this);

        return true;
    }

    public function getTrances(): array
    {
        return $this->tranches;
    }

}
