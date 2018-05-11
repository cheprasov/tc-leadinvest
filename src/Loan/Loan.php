<?php

namespace TC\Lendinvest\Loan;

use TC\Lendinvest\Exception\DuplicateTrancheForLoadException;
use TC\Lendinvest\Exception\IncorrectDateException;
use TC\Lendinvest\Loan\Tranche\TrancheInterface;
use TC\Lendinvest\Utils\Date;

class Loan implements LoanInterface
{
    /**
     * @var string
     */
    protected $dateBeg;

    /**
     * @var string
     */
    protected $dateEnd;

    /**
     * @var TrancheInterface[]
     */
    protected $tranches = [];

    /**
     * @param string $begDate
     * @param string $endDate
     */
    public function __construct(string $dateBeg, string $dateEnd)
    {
        if (!Date::isCorrectDate($dateBeg) || !Date::isCorrectDate($dateEnd) || $dateBeg >= $dateEnd) {
            throw new IncorrectDateException();
        }
        $this->dateBeg = $dateBeg;
        $this->dateEnd = $dateEnd;
    }

    /**
     * @inheritdoc
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

    /**
     * @return TrancheInterface[]
     */
    public function getTranches(): array
    {
        return $this->tranches;
    }

    /**
     * @inheritdoc
     */
    public function getDateBeg(): string
    {
        return $this->dateBeg;
    }

    /**
     * @inheritdoc
     */
    public function getDateEnd(): string
    {
        return $this->dateEnd;
    }
}
